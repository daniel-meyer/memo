<?php /* Smarty version 2.6.26, created on 2013-07-18 20:57:51
         compiled from C:%5Cwamp%5Cwww%5Cmemo%5Capplication/modules/admin/views/memo/import-srt.tpl */ ?>
<h2>Słówka</h2>
<p>Import słowek</p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Import</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
        
             <p>
                <label for="content">Plik srt</label>
                <input type="file" name="file" />
             </p>

            <?php if ($this->_tpl_vars['words']): ?>
            <table class="table table-bordered table-striped">
                <tbody>                      
                    <?php $_from = $this->_tpl_vars['words']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['item']):
?>
                    <?php if ($this->_tpl_vars['item']): ?>
                        <tr>
                           <td><?php echo $this->_tpl_vars['item']; ?>
</td>
                           <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button class="btn btn-success">Known</button>
                                    <button class="btn btn-primary">To learn</button>
                                    <button class="btn active">Ignored</button>
                                </div>
                           </td>
                        </tr>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                </tbody>
            </table>
            <?php endif; ?>
            
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" ><?php if ($this->_tpl_vars['words']): ?>Zapisz<?php else: ?>Wyczytaj plik<?php endif; ?></button>
    <a href="<?php echo $this->callViewHelper('url',array(array('action' => 'index','id' => null,))); ?>" class="btn" >Powrót</a>
    
</form>