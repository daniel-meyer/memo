<h2>Użytkownicy</h2>
<p>Edycja konta użytkownika: <strong>{$item->getFirstname()} {$item->getLastname()}</strong></p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Edycja</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <p>
                <label for="firstname">Imię</label>
                <input id="firstname" name="firstname" value="{$request->getPost('firstname')|default:$item->getFirstname()}" type="text" class="text small" />
                {validate check="notEmpty:#firstname" message='<span class="error">Nieprawidłowe imię</span>'}
            </p>
            
            <p>
                <label for="lastname">Nazwisko</label>
                <input id="lastname" name="lastname" value="{$request->getPost('lastname')|default:$item->getLastname()}" type="text" class="text small" />
                {validate check="notEmpty:#lastname" message='<span class="error">Nieprawidłowe nazwisko</span>'}
            </p>
            
            <p>
                <label for="email">Email</label>
                <input id="email" name="email" value="{$request->getPost('email')|default:$item->getEmail()}" type="text" class="text small" />
                {validate check="isEmail:#email" message='<span class="error">Nieprawidłowy adres email</span>'}
            </p>
            
            <p>
                <label for="province_id">Województwo</label>
                <select id="province_id" name="province_id" class="select">
                    {html_options options=$provinces selected=$request->getPost('province_id')|default:$item->getProvinceId()}
                </select>
                {validate check="notEmpty:#province_id" message='<span class="error">Wybierz województwo</span>'}
            </p>
            
            <input name="change_pass" value="{$request->getPost('change_pass')}" type="hidden" class="toogle_input" />
            <h3 class="toogle_trigger"><a href="#">Zmień hasło</a></h3>
            <div class="toogle_container">
                <div class="block">
                	<p>
                        <label for="new_pass">Nowe hasło</label>
                        <input id="new_pass" name="new_pass" value="" type="password" class="text small" />
                        {validate check="notEmpty:#change_pass=>notEmpty:#new_pass" message='<span class="error">Podaj nowe hasło</span>'}
                    </p>
                    <p>
                        <label for="confirm_pass">Powtórz hasło</label>
                        <input id="confirm_pass" name="confirm_pass" value="" type="password" class="text small" />
                        {validate check="notEmpty:#change_pass=>equals:#new_pass:#confirm_pass" message='<span class="error">Hasła muszą być takie same</span>'}
                    </p>
                </div>
            </div>
            
                
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" >Zapisz</button>
    <a href="{url a.action=index a.id=null}" class="btn" >Powrót</a>
    
</form>

{literal}
<script type="text/javascript">
jQuery(document).ready(function(){
    
    $('.toogle_input').each(function(){
        var h3 = $(this).next('.toogle_trigger');
        if($(this).attr('value')=='1'){
            h3.addClass('active');  
            h3.next('.toogle_container').show();
        }else{
            h3.removeClass('active');  
            h3.next('.toogle_container').hide();
        }  
    })
  
	$('.toogle_trigger').click(function() {
        if($(this).hasClass('active')){
            $(this).next('.toogle_container').hide('slow');
            $(this).prev('.toogle_input').attr('value', 0);
            $(this).removeClass('active');        
        }else{
            $(this).next('.toogle_container').show('slow');
            $(this).prev('.toogle_input').attr('value', 1);
            $(this).addClass('active');
        }
		
		return false;
	});
});
</script>
{/literal}