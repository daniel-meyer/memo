<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:32
         compiled from pager.tpl */ ?>
<?php if ($this->_tpl_vars['paginator']->getPages()->pageCount > 1): ?>
<div class="clearfix">
<ul id="pagination">
   <!-- Previous page link -->
<?php if ($this->_tpl_vars['paginator']->getPages()->previous): ?>
  <li class="previous"><a href="<?php echo $this->callViewHelper('url',array(array('page' => $this->_tpl_vars['paginator']->getPages()->previous,))); ?>">
    &lt; Poprzednia
  </a></li>
<?php else: ?>
    <li class="previous-off">&lt; Poprzednia</li>
<?php endif; ?>

<?php if ($this->_tpl_vars['paginator']->getPages()->firstPageInRange > 1): ?>
    <li><a href="<?php echo $this->callViewHelper('url',array(array('page' => 1,))); ?>">1</a></li>
    <?php if ($this->_tpl_vars['paginator']->getPages()->firstPageInRange > 2): ?>
        <li class="disabled"><a href="javascript:;">...</a></li>
    <?php endif; ?>
<?php endif; ?>

<!-- Numbered page links -->
<?php $_from = $this->_tpl_vars['paginator']->getPages()->pagesInRange; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['paginator_page']):
?>
    <?php if ($this->_tpl_vars['paginator_page'] != $this->_tpl_vars['paginator']->getPages()->current): ?>
        <li>
            <a href="<?php echo $this->callViewHelper('url',array(array('page' => $this->_tpl_vars['paginator_page'],))); ?>">
                <?php echo $this->_tpl_vars['paginator_page']; ?>

            </a>
        </li>
    <?php else: ?>
        <li class="active"><?php echo $this->_tpl_vars['paginator_page']; ?>
</li>
    <?php endif; ?>
<?php endforeach; endif; unset($_from); ?>

<?php if ($this->_tpl_vars['paginator']->getPages()->lastPageInRange != $this->_tpl_vars['paginator']->getPages()->pageCount): ?>
    <?php if ($this->_tpl_vars['paginator']->getPages()->lastPageInRange != $this->_tpl_vars['paginator']->getPages()->pageCount-1): ?>
        <li class="disabled"><a href="javascript:;">...</a></li>
    <?php endif; ?>
    <li><a href="<?php echo $this->callViewHelper('url',array(array('page' => $this->_tpl_vars['paginator']->getPages()->pageCount,))); ?>"><?php echo $this->_tpl_vars['paginator']->getPages()->pageCount; ?>
</a></li>
<?php endif; ?>

<!-- Next page link -->
<?php if ($this->_tpl_vars['paginator']->getPages()->next): ?>
    <li class="next">
        <a href="<?php echo $this->callViewHelper('url',array(array('page' => $this->_tpl_vars['paginator']->getPages()->next,))); ?>">
            Następna &gt;
        </a>
    </li>
<?php else: ?>
  <li class="next-off">Następna &gt;</li>
<?php endif; ?>
</ul>


</div>  
<?php endif; ?>

        