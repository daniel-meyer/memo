<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:15
         compiled from C:%5Cwamp%5Cwww%5Cmemo%5Capplication/layouts/default.tpl */ ?>
<?php echo $this->callViewHelper('doctype',array()); ?>
<html lang="<?php echo $this->_tpl_vars['lang']; ?>
">

    <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>



 <body>
            
    <!-- Topbar -->
    
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

          <a href="/" class="brand"><?php echo $this->_tpl_vars['settings']->siteTitle; ?>
</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="admin">Logowanie</a>
              </li>
              <!-- <li class="active">
                <a href="./getting-started.html">Get started</a>
              </li>
               -->
            </ul>
          </div>
        </div>
      </div>
    </div>
           


    <div class="quickstart"  style="padding-top:40px; position: relative; min-height:700px">
          <div class="container">
            <div class="row">
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "flash-message.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                        <?php echo $this->callViewHelper('layout',array('content')); ?>             </div><!-- /row -->
          </div>
    </div>
    
    <footer>
    <div class="container">
        <p>&copy; 2013 Memo</p>
        </div>
    </footer>    
    
   
</body>
</html>