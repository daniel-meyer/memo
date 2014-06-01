{doctype}
<html lang="pl">

    {include file="head.tpl"}

    <body>
        <header id="header" class="png_bg">

            <div id="head_wrap" class="container">
                <div class="row">
                    <!-- start of logo - you could replace this with an image of your logo -->
                    <div id="logo" class="span4">
                        <h1><img src="public/admin/images/logo_etd_white.png" /></h1>
                    </div>
                    <!-- end logo -->

                    <!-- start control panel -->
                    <div id="controlpanel" class="span8">

                        <ul>

                            <li><p>Zalogowany <strong>{$user->getFirstname()} {$user->getLastname()}</strong></p></li>
                            <li><a href="" class="first" target="_blank">Widok strony</a></li>
                            <li><a href="admin" class="first">Admin</a></li>
                            <li><a href="admin/auth/logout" class="last">Wyloguj</a></li>

                        </ul>

                    </div>
                    <!-- end control panel -->
                </div>
                <!-- start navigation -->
                {include file="menu.tpl"}
                <!-- end navigation -->

            </div><!-- end headwarp  -->
        </header><!-- end header -->


        <!-- staqrt subnav -->
        <nav id="sub_nav">
            <div id="subnav_wrap" class="container">

                <!-- start sub nav list -->
                {include file="sub_menu.tpl"}

                <!-- end subnavigation list -->	

            </div>
        </nav>
        <!-- end sub_nav -->

        <!-- EVERYTING BELOW IS THE MAIN CONTENT -->

        <div id="main_content_wrap" class="container">

            {include file="flash-message.tpl"}
            {layout attrib="content"} {* włączane podstrony *}	

        </div>

        <footer class="footer container">

            <!-- START FOOTER -->
            {include file="footer.tpl"}

            <!-- END FOOTER -->       
        </footer><!-- end content wrap -->


    </body>
</html>