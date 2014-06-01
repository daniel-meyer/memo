<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:21
         compiled from C:%5Cwamp%5Cwww%5Cmemo%5Capplication/modules/admin/views/index/index.tpl */ ?>
<!-- start icon dock-->
<div id="icondock" class="clearfix">

    <ul>
        <?php $_from = $this->_tpl_vars['dashboard']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <li>
                <a href="<?php echo $this->_tpl_vars['lang']; ?>
/<?php echo $this->_tpl_vars['item']['link']; ?>
" title="<?php echo $this->_tpl_vars['item']['comments']; ?>
" <?php if ($this->_tpl_vars['item']['facebox']): ?>rel="facebox"<?php endif; ?>>
                    <?php if ($this->_tpl_vars['item']['icon']): ?>
                        <img src="public/admin/images/icondock/<?php echo $this->_tpl_vars['item']['icon']; ?>
.png" alt="<?php echo $this->_tpl_vars['item']['name']; ?>
" />
                    <?php endif; ?>
                    <br /><?php echo $this->_tpl_vars['item']['name']; ?>

                <?php if ($this->_tpl_vars['item']['amount']): ?><span><?php echo $this->_tpl_vars['item']['amount']; ?>
</span><?php endif; ?>
            </a>
        </li>
    <?php endforeach; endif; unset($_from); ?>

</ul>


</div><!-- end icon dock-->

<div class="row">

    <div id="notices" class="span4">

        <h2>Menu</h2>
        <ul class="tree">
            <?php if ($this->_tpl_vars['showHome']): ?>
                <li class="tree_lvl1">
                    <a href="<?php echo $this->_tpl_vars['lang']; ?>
/admin/module-home/index/pageid/<?php echo $this->_tpl_vars['root']->getId(); ?>
">
                        <i class="icon-page icon-file"></i> <span>Strona główna</span>
                    </a>
                    <ul>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['request']->controller)."/tree.tpl", 'smarty_include_vars' => array('pageItems' => $this->_tpl_vars['pages'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                    </ul>
                </li>
            <?php else: ?>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['request']->controller)."/tree.tpl", 'smarty_include_vars' => array('pageItems' => $this->_tpl_vars['pages'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
        </ul>
    </div>

    <!--  PLACEHOLDER FOR FLOT - REMOVE IF NOT REQUIRED -->
    <div class="span8">

        <h2>Statystyki odwiedzin</h2>

        <div id="placeholder" style="display:none;margin:auto"><?php echo $this->_tpl_vars['jsonStatystykaWejsc']; ?>
</div> 

    </div>

</div>