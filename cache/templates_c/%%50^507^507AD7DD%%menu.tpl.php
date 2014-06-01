<?php /* Smarty version 2.6.26, created on 2013-07-18 20:56:36
         compiled from menu.tpl */ ?>

<div id="navigation" class=" grid_12">
        <ul>
        <?php $_from = $this->_tpl_vars['aMenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kij'] => $this->_tpl_vars['item']):
?>
            <li>
            <?php if ($this->_tpl_vars['item']['link']): ?><a id="menu_id<?php echo $this->_tpl_vars['kij']; ?>
" href="<?php echo $this->_tpl_vars['item']['link']; ?>
"  <?php if ($this->_tpl_vars['item']['active']): ?>class="active"<?php endif; ?> ><?php echo $this->_tpl_vars['item']['name']; ?>
</a>
    <?php else: ?><a id="menu_id<?php echo $this->_tpl_vars['kij']; ?>
" href="javascript:void(0);"  <?php if ($this->_tpl_vars['item']['active']): ?>class="active"<?php endif; ?> ><?php echo $this->_tpl_vars['item']['name']; ?>
</a><?php endif; ?>
</li>
<?php endforeach; endif; unset($_from); ?>
</ul>
</div>