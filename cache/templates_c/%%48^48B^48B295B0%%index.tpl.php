<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:32
         compiled from C:%5Cwamp%5Cwww%5Cmemo%5Capplication/modules/admin/views/memo/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'textcut', 'C:\\wamp\\www\\memo\\application/modules/admin/views/memo/index.tpl', 21, false),)), $this); ?>
<h2>Słówka(<?php echo $this->_tpl_vars['paginator']->getPages()->totalItemCount; ?>
)</h2>
<p>Zarządzaj listą słówek</p>

  
<a class="btn btn-primary" href="<?php echo $this->callViewHelper('url',array(array('action' => 'add',))); ?>">Dodaj</a>
<a class="btn btn-success" href="<?php echo $this->callViewHelper('url',array(array('action' => 'import',))); ?>">Import</a>
<a class="btn btn-success" href="<?php echo $this->callViewHelper('url',array(array('action' => 'import-srt',))); ?>">Import srt</a>
<a class="btn btn-info" href="<?php echo $this->callViewHelper('url',array(array('action' => 'export',))); ?>">Export</a>
<a class="btn" href="<?php echo $this->_tpl_vars['lang']; ?>
/admin">Powrót</a>
<div>&nbsp;</div>


<table class="table table-striped">

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "sort.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>    
    <tbody>
	<?php $_from = $this->_tpl_vars['paginator']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<tr>
		<td class="lp"><?php echo $this->_tpl_vars['item']->getId(); ?>
</td>
		<td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->getQuestion())) ? $this->_run_mod_handler('textcut', true, $_tmp, 255) : smarty_modifier_textcut($_tmp, 255)); ?>
</td>
        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['item']->getAnswer())) ? $this->_run_mod_handler('textcut', true, $_tmp, 255) : smarty_modifier_textcut($_tmp, 255)); ?>
</td>
		

        
		<td class="center">
            <?php if ($this->_tpl_vars['item']->getActive() == 2): ?>
                <i class="admin-sprite" style="background-position: <?php if ($this->_tpl_vars['item']->getActive()): ?>-100px<?php else: ?>0<?php endif; ?> -120px;" title="Wyeksportowane do supermemo" class="tip"></i>
            <?php else: ?>
                <a href="<?php echo $this->callViewHelper('url',array(array('action' => 'ajax-active','id' => $this->_tpl_vars['item']->getId(),'status' => $this->_tpl_vars['item']->getActive(),))); ?>" title="Status" class="tip ajaxStatus" >
                    <i class="admin-sprite" style="background-position: <?php if ($this->_tpl_vars['item']->getActive()): ?>-20px<?php else: ?>0<?php endif; ?> -120px;"></i>
                </a>
            <?php endif; ?>    
        </td>

		<td class="edit">
            <a href="<?php echo $this->callViewHelper('url',array(array('action' => 'edit','id' => $this->_tpl_vars['item']->getId(),))); ?>" class="btn btn-mini btn-primary">Edytuj</a>
			<a href="<?php echo $this->callViewHelper('url',array(array('action' => 'delete','id' => $this->_tpl_vars['item']->getId(),))); ?>" onClick="return(window.confirm('Czy na pewno chcesz skasować daną pozycję?'));" class="btn btn-mini btn-danger">Usuń</a>
		</td>						
	</tr>
	<?php endforeach; endif; unset($_from); ?>
    </tbody>
</table>    


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "pager.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>  
    
