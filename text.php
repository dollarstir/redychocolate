
<?php
function get_available_cleaner($con, $order_id) {
    $order_data = record_data($con, "id", $order_id, "cleaning_orders");

    $assigned_cleaner_id = $order_data['assigned_cleaner_id'];
    $cleaner_accept_status = $order_data['cleaner_accept_status'];

    $cleaningOrderLocation = explode(',', $order_data['coordinates']);
    $orderLatitude = $cleaningOrderLocation[0];
    $orderLongitude = $cleaningOrderLocation[1];

    if ($assigned_cleaner_id > 0 && $cleaner_accept_status > 0) {
      $cleaner_data = record_data($con, "id", $assigned_cleaner_id, "cleaners");

      $cleaner_data['time_interval'] = get_time_interval($cleaner_data['timestamp']);
      
      // Prepare and execute SQL query
      $stats_sql = mysqli_query($con, "SELECT AVG(cleaner_rating) AS average_rating, COUNT(cleaner_rating) AS number_of_washes FROM cleaning_orders WHERE cleaner_accept_status = 1 AND status = 'Completed' AND assigned_cleaner_id = $assigned_cleaner_id");
      $stats_data = mysqli_fetch_assoc($stats_sql);
      $average_cleaner_rating = $stats_data['average_rating'] ?? 5.00;
      $number_of_washes = $stats_data['number_of_washes'] ?? 0;

      $cleaner_data['average_cleaner_rating'] = number_format($average_cleaner_rating, 2, '.', '');
      $cleaner_data['number_of_washes'] = (string)$number_of_washes;
      
      // Return the closest cleaner's data
      return array('status' => 'Found', 'available_cleaner' => $cleaner_data, 'order_data' => $order_data);

    } else if ($assigned_cleaner_id > 0 && $cleaner_accept_status == 0) {

        return array('status' => 'Not found');

    } else {
  
      $query = "SELECT 
                  u.id, 
                  u.first_name, 
                  u.last_name,
                  u.phone,
                  u.profile_image,
                  u.gps_coordinates,
                  u.timestamp,
                  haversineDistance(SUBSTRING_INDEX(u.gps_coordinates, ',', 1), SUBSTRING_INDEX(u.gps_coordinates, ',', -1), $orderLatitude, $orderLongitude) AS distance
                  FROM
                  cleaners u
                  WHERE 
                  u.is_available = 1 AND haversineDistance(SUBSTRING_INDEX(u.gps_coordinates, ',', 1), SUBSTRING_INDEX(u.gps_coordinates, ',', -1), $orderLatitude, $orderLongitude) < 54.00
                  GROUP BY 
                  u.id
                  ORDER BY 
                  distance ASC
                  LIMIT 1";
  
      $result = mysqli_query($con, $query) or die(mysqli_error($con));
  
      if ($result && mysqli_num_rows($result) > 0) {
          // Fetch the first user from the result set
          $closestCleaner = mysqli_fetch_assoc($result);
          $closestCleaner['time_interval'] = get_time_interval($closestCleaner['timestamp']);
          $cleaner_id = $closestCleaner['id'];
  
          // Prepare and execute SQL query
          $stats_sql = mysqli_query($con, "SELECT AVG(cleaner_rating) AS average_rating, COUNT(cleaner_rating) AS number_of_washes FROM cleaning_orders WHERE cleaner_accept_status = 1 AND `status` = 'Completed' AND assigned_cleaner_id = $cleaner_id");
          $stats_data = mysqli_fetch_assoc($stats_sql);
          $average_cleaner_rating = $stats_data['average_rating'] ?? 5.00;
          $number_of_washes = $stats_data['number_of_washes'] ?? 0;
  
          $closestCleaner['average_cleaner_rating'] = number_format($average_cleaner_rating, 2, '.', '');
          $closestCleaner['number_of_washes'] = (string)$number_of_washes;
  
          $clean_data = array(
              'order_id' => $order_id,
              'assigned_cleaner_id' => $cleaner_id,
          );
  
          $notification_id = add_record($con, $clean_data, "cleaning_order_notification");
          update_record($con, array('assigned_cleaner_id' => $cleaner_id, 'notification_id' => $notification_id), "cleaning_orders", "id = $order_id");
  
          // Return the closest cleaner's data
          return array('status' => 'Not found');
      } else {
          // Query failed or returned an empty result set
          return array('status' => 'Not found');
      }
  
    }
}

function get_time_interval($timestamp) {
    // Convert the timestamp to a DateTime object
    $dateTime = new DateTime($timestamp);
    $now = new DateTime();

    // Get the difference between the current time and the given timestamp
    $timeDifference = $now->diff($dateTime);

    // Create the approximate time interval string
    if ($timeDifference->s < 60 && $timeDifference->i == 0 && $timeDifference->h == 0 && $timeDifference->d == 0) {
        return $timeDifference->s . " second" . ($timeDifference->s == 1 ? '' : 's');
    } else if ($timeDifference->i < 60 && $timeDifference->h == 0 && $timeDifference->d == 0) {
        return $timeDifference->i . " minute" . ($timeDifference->i == 1 ? '' : 's');
    } else if ($timeDifference->h < 24 && $timeDifference->d == 0) {
        return $timeDifference->h . " hour" . ($timeDifference->h == 1 ? '' : 's');
    } else if ($timeDifference->d < 7) {
        return $timeDifference->d . " day" . ($timeDifference->d == 1 ? '' : 's');
    } else if ($timeDifference->d / 7 < 4) {
        return floor($timeDifference->d / 7) . " week" . (floor($timeDifference->d / 7) == 1 ? '' : 's');
    } else if ($timeDifference->m < 12) {
        return $timeDifference->m . " month" . ($timeDifference->m == 1 ? '' : 's');
    } else {
        return $timeDifference->y . " year" . ($timeDifference->y == 1 ? '' : 's');
    }
}