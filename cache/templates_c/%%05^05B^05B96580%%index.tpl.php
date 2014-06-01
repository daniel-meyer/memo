<?php /* Smarty version 2.6.26, created on 2013-07-22 19:51:15
         compiled from C:%5Cwamp%5Cwww%5Cmemo%5Capplication/modules/default/views/index/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'translate', 'C:\\wamp\\www\\memo\\application/modules/default/views/index/index.tpl', 20, false),)), $this); ?>
<?php echo '
<script type="text/javascript">
$(document).ready(function() {
    setTimeout("document.getElementById(\'question\').focus()",100);
});
</script>
'; ?>

<div id="formContainer"  style="position: relative;; ">
   
    <form class="contact-form" id="contact-form" action="memo/send" >
        <input type="hidden" name="lang" value="<?php echo $this->_tpl_vars['lang']; ?>
" />
        <fieldset>
            <div class="formRow"><label for="question">Question:</label><textarea id="question"  name="question" ></textarea></div>
            <div class="formRow"><label for="answer">Answer:</label><textarea id="answer"  name="answer" ></textarea></div>
            <div class="buttons">
                <button class="btn" type="submit" >Send</button>
            </div>
        </fieldset>
        <div class="thank-you">
            <h2><?php echo ((is_array($_tmp='Thank You!')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
</h2>
            <p><?php echo ((is_array($_tmp='We will be in touch soon.')) ? $this->_run_mod_handler('translate', true, $_tmp) : smarty_modifier_translate($_tmp)); ?>
</p>
        </div>
    </form>
    
    
</div>