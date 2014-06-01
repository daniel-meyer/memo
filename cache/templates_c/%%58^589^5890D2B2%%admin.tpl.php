<?php /* Smarty version 2.6.26, created on 2013-07-18 20:56:36
         compiled from C:%5Cwamp%5Cwww%5Cmemo%5Capplication/layouts/admin.tpl */ ?>
<?php echo $this->callViewHelper('doctype',array()); ?>
<html lang="pl">

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

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

                            <li><p>Zalogowany <strong><?php echo $this->_tpl_vars['user']->getFirstname(); ?>
 <?php echo $this->_tpl_vars['user']->getLastname(); ?>
</strong></p></li>
                            <li><a href="" class="first" target="_blank">Widok strony</a></li>
                            <li><a href="admin" class="first">Admin</a></li>
                            <li><a href="admin/auth/logout" class="last">Wyloguj</a></li>

                        </ul>

                    </div>
                    <!-- end control panel -->
                </div>
                <!-- start navigation -->
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                <!-- end navigation -->

            </div><!-- end headwarp  -->
        </header><!-- end header -->


        <!-- staqrt subnav -->
        <nav id="sub_nav">
            <div id="subnav_wrap" class="container">

                <!-- start sub nav list -->
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sub_menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

                <!-- end subnavigation list -->	

            </div>
        </nav>
        <!-- end sub_nav -->

        <!-- EVERYTING BELOW IS THE MAIN CONTENT -->

        <div id="main_content_wrap" class="container">

            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "flash-message.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php echo $this->callViewHelper('layout',array('content')); ?> 	

        </div>

        <footer class="footer container">

            <!-- START FOOTER -->
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

            <!-- END FOOTER -->       
        </footer><!-- end content wrap -->


    </body>
</html>