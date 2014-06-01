<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:21
         compiled from index/tree.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'textcut', 'index/tree.tpl', 8, false),)), $this); ?>
<?php $_from = $this->_tpl_vars['pageItems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <li class="tree_lvl<?php echo $this->_tpl_vars['item']['page']->getLvl(); ?>
">
        <a 
            <?php if ($this->_tpl_vars['item']['page']->getType() == 'module' && $this->_tpl_vars['item']['page']->getModule() != 'container'): ?>href="<?php echo $this->_tpl_vars['lang']; ?>
/admin/module-<?php echo $this->_tpl_vars['item']['page']->getModule(); ?>
/index/pageid/<?php echo $this->_tpl_vars['item']['page']->getId(); ?>
"
        <?php else: ?>href="javascript:;"<?php endif; ?> 
        >
        <i class="icon-page icon-file"></i>        <span><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['page']->getMenuTitle())) ? $this->_run_mod_handler('textcut', true, $_tmp, 40) : smarty_modifier_textcut($_tmp, 40)); ?>
</span>
    </a>

    <?php if ($this->_tpl_vars['item']['children']): ?>
        <ul>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ($this->_tpl_vars['request']->controller)."/tree.tpl", 'smarty_include_vars' => array('pageItems' => $this->_tpl_vars['item']['children'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        </ul>
    <?php endif; ?>
</li>
<?php endforeach; endif; unset($_from); ?>