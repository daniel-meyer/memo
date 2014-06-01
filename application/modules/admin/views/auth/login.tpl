<form method="post" action="admin/auth" id="loginform" class="form-horizontal">
    <input name="referer" value="{$smarty.post.referer|default:$aclRedirect}" type="hidden" />

    <fieldset> 
          <div class="control-group">
            <div class="controls">
              <p>Podaj swój email i hasło. </p>
            </div>
          </div>
        
          
          <div class="control-group">
            <label for="username" class="control-label">E-mail</label>
            <div class="controls">
              <input type="text" id="username" name="username" class="required" tabindex="1" />
            </div>
          </div>
          
          <div class="control-group">
            <label for="password" class="control-label">Hasło</label>
            <div class="controls">
              <input type="password" id="password" name="password"  class="required" tabindex="2" />
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
              <button type="submit" name="auth" value="1" class="btn btn-primary" tabindex="3">Zaloguj się</button>
              &nbsp;
              <label class="checkbox inline">
                <input type="checkbox" value="1" name="rememberme" tabindex="4" />
                Zapamiętaj mnie
              </label>
            </div>
          </div>
          
          <div class="control-group">
            <div class="controls">
              <p>Jeśli zapomniałeś hasła <a href="admin/auth/password-reset">kliknij tutaj</a></p>
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