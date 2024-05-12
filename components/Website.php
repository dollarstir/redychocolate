<?php
class Website{


    public static function footer(): string
    {
 return '	<footer id="main-footer">



 <div id="footer-bottom">
     <div class="container clearfix">
         <ul class="et-social-icons">

             <li class="et-social-icon et-social-facebook">
                 <a href="https://www.facebook.com/The-Chocolate-Factory-441643873026816/" class="icon">
                     <span>Facebook</span>
                 </a>
             </li>
             <li class="et-social-icon et-social-instagram">
                 <a href="https://www.instagram.com/chocolatefactory_stmaryslondon/" class="icon">
                     <span>Instagram</span>
                 </a>
             </li>
             <li class="et-social-icon et-social-rss">
                 <a href="feed/index.rss" class="icon">
                     <span>RSS</span>
                 </a>
             </li>

         </ul>
     </div>
 </div>
</footer>';
    }

    public static function topbar(): string
    {
        return '<div id="top-header">
        <div class="container clearfix">


            <div id="et-info">
                <span id="et-info-phone">+1619-240-4437</span>

                <a href="mailto:info@richeddychocolatecompany.com"><span
                        id="et-info-email">info@richeddychocolatecompany.com</span></a>

                <ul class="et-social-icons">

                    <li class="et-social-icon et-social-facebook">
                        <a href="https://www.facebook.com/" class="icon">
                            <span>Facebook</span>
                        </a>
                    </li>
                    <li class="et-social-icon et-social-instagram">
                        <a href="https://www.instagram.com/" class="icon">
                            <span>Instagram</span>
                        </a>
                    </li>
                    <li class="et-social-icon et-social-rss">
                        <a href="feed/index.rss" class="icon">
                            <span>RSS</span>
                        </a>
                    </li>

                </ul>
            </div>


            <div id="et-secondary-menu">
                <div class="et_duplicate_social_icons">
                    <ul class="et-social-icons">

                        <li class="et-social-icon et-social-facebook">
                            <a href="https://www.facebook.com/" class="icon">
                                <span>Facebook</span>
                            </a>
                        </li>
                        <li class="et-social-icon et-social-instagram">
                            <a href="https://www.instagram.com/" class="icon">
                                <span>Instagram</span>
                            </a>
                        </li>
                        <li class="et-social-icon et-social-rss">
                            <a href="feed/index.rss" class="icon">
                                <span>RSS</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>

        </div>
    </div>


    <header id="main-header" data-height-onload="66">
        <div class="container clearfix et_menu_container">
            <div class="logo_container">
                <span class="logo_helper"></span>
                <a href="index.php">
                    <img src="wp-content/uploads/2018/01/chocolate-factory-logo.png" width="250" height="159"
                        alt="The Chocolate Factory" id="logo" data-height-percentage="100" />
                </a>
            </div>
            <div id="et-top-navigation" data-height="66" data-fixed-height="40">
                <nav id="top-menu-nav">
                    <ul id="top-menu" class="nav">
                        <li id="menu-item-48694"
                            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-48694">
                            <a href="index.php" aria-current="page">HOME</a></li>
                        <li id="menu-item-50332"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-50332">
                            <a href="#">SEASONAL SPECIALS</a>
                            <ul class="sub-menu">
                                <li id="menu-item-49879"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-49879">
                                    <a href="easter/index.php">EASTER</a></li>
                                <li id="menu-item-50131"
                                    class="menu-item menu-item-type-post_type menu-item-object-page menu-item-50131">
                                    <a href="valentines/index.php">VALENTINES</a></li>
                            </ul>
                        </li>
                        <li id="menu-item-50375"
                            class="menu-item menu-item-type-post_type menu-item-object-page menu-item-50375"><a
                                href="chocolate-gallery/index.php">CHOCOLATES</a></li>
                        <li id="menu-item-48693"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-48693"><a
                                href="#">CORPORATE GIFTS</a></li>
                    </ul>
                </nav>




                <div id="et_mobile_nav_menu">
                    <div class="mobile_nav closed">
                        <span class="select_page">Select Page</span>
                        <span class="mobile_menu_bar mobile_menu_bar_toggle"></span>
                    </div>
                </div>
            </div> <!-- #et-top-navigation -->
        </div> <!-- .container -->
    </header> <!-- #main-header -->';

    }

   public static function head()
   {

    require_once __DIR__ . '/head.php';
   }
}