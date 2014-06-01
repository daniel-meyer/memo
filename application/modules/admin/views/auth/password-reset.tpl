<form method="post" action="" id="loginform" class="form-horizontal">

    <fieldset> 
          <div class="control-group">
            <div class="controls">
              <h2>Zapomniałeś hasła?</h2>
              <p>
              Na podany e-mail prześlemy Ci link
			umożliwijący zmianę hasła.</p>
            </div>
          </div>
        
          
          <div class="control-group">
            <label for="username" class="control-label">E-mail</label>
            <div class="controls">
              <input type="text" id="username" name="username" class="required" tabindex="1" />
            </div>
          </div>
          
          
        {if $message} 
              <div class="control-group error-top">
                <div class="controls">
                    <label class="error">{$message}</label>
                </div>
              </div>
        {/if}
          
          
          <div class="control-group">
            <div class="controls">
              <button type="submit" name="auth" value="1" class="btn btn-primary" tabindex="3">Wyślij</button>
             
            </div>
          </div>
          
          <div class="control-group">
            <div class="controls">
              <p><a href="admin/auth">Powrót</a></p>
            </div>
          </div>
     
          
          
          
    </fieldset>
</form>


{literal}
<script>
$(document).ready(function() {
    setTimeout(function(){
        $("#loginform input[name=username]").focus();
    },100);
	$("#loginform").validate();
});
</script>
{/literal}