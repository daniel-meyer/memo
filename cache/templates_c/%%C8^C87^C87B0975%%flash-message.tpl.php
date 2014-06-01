<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:15
         compiled from flash-message.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substr', 'flash-message.tpl', 18, false),)), $this); ?>
<?php if ($this->_tpl_vars['messages']): ?>
    <?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
        <div class="alert
        <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'succ'): ?>alert-success<?php endif; ?>
    <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'info'): ?>alert-info<?php endif; ?>
<?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'fail'): ?>alert-error<?php endif; ?>
<?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'warn'): ?><?php endif; ?>

">

    <a class="close" data-dismiss="alert">×</a>
    <strong>
    <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'succ'): ?>Sukces!<?php endif; ?>
<?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'info'): ?>Informacja:<?php endif; ?>
<?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'fail'): ?>Błąd!<?php endif; ?>
<?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'warn'): ?>Uwaga!<?php endif; ?>
</strong> 
<?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('substr', true, $_tmp, 5) : substr($_tmp, 5)); ?>


</div>


<?php endforeach; endif; unset($_from); ?>
<?php endif; ?> 