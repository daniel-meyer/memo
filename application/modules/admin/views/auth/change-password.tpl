<form method="post" action="" id="loginform" class="form-horizontal">
    <input type="hidden" name="id" value="{$id}" />
    <fieldset> 
          <div class="control-group">
            <div class="controls">
              <h2>Wpisz nowe hasło</h2>
              <p>Minimalnie 6 a maksymalnie 16 znaków; bez polskich znaków; wyłącznie znaki alfanumeryczne "a-z" , "A-Z" oraz "_"</p>
            </div>
          </div>
        
          
          <div class="control-group">
            <label for="haslo" class="control-label">Hasło</label>
            <div class="controls">
              <input type="text" id="haslo" name="haslo" class="required" tabindex="1" />
              {validate check="isPass:#haslo" message='<span style="color:red;font-weight:bold;">&nbsp;Nieprawidłowe hasło</span>'}
            </div>
          </div>
          
          <div class="control-group">
            <label for="haslo2" class="control-label">Powtórz hasło</label>
            <div class="controls">
              <input type="text" id="haslo2" name="haslo2" class="required" tabindex="2" />
              {validate check="equals:#haslo:#haslo2" message='<span style="color:red;font-weight:bold;">&nbsp;Hasła muszą być takie same</span>'}
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
              <button type="submit" name="auth" value="1" class="btn btn-primary" tabindex="3">Zmień hasło</button>
             
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
        $("#loginform input[name=haslo]").focus();
    },100);
	$("#loginform").validate();
});
</script>
{/literal}