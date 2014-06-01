<?php /* Smarty version 2.6.26, created on 2013-07-18 20:56:36
         compiled from flash-message.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'substr', 'flash-message.tpl', 3, false),)), $this); ?>
<?php if ($this->_tpl_vars['messages']): ?>
    <?php $_from = $this->_tpl_vars['messages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <div class="notification <?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('substr', true, $_tmp, 0, 4) : substr($_tmp, 0, 4)); ?>
 canhide">
      <p><strong>
          <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'succ'): ?>SUKCES:<?php endif; ?>
          <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'info'): ?>INFORMACJA:<?php endif; ?>
          <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'fail'): ?>BŁĄD:<?php endif; ?>
          <?php if (substr ( $this->_tpl_vars['item'] , 0 , 4 ) == 'warn'): ?>UWAGA:<?php endif; ?>
       </strong> <?php echo ((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('substr', true, $_tmp, 5) : substr($_tmp, 5)); ?>
</p>
	</div>
    <?php endforeach; endif; unset($_from); ?>
<?php endif; ?>    