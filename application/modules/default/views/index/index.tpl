{literal}
<script type="text/javascript">
$(document).ready(function() {
    setTimeout("document.getElementById('question').focus()",100);
});
</script>
{/literal}
<div id="formContainer">
   
    <form class="contact-form" id="contact-form" action="memo/send" >
        <input type="hidden" name="lang" value="{$lang}" />
        <fieldset>
            <div class="formRow"><label for="question">Question:</label><textarea id="question"  name="question" ></textarea></div>
            <div class="formRow"><label for="answer">Answer:</label><textarea id="answer"  name="answer" ></textarea></div>
            <div class="buttons">
                <button class="btn btn-primary" type="submit" >Send</button>
            </div>
        </fieldset>
        <div class="thank-you">
            <h2>{'Thank You!'|translate}</h2>
            <p>{'We will be in touch soon.'|translate}</p>
        </div>
    </form>
    
    
</div>