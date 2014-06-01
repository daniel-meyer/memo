<h2>Użytkownicy</h2>
<p>Utworzenie konta użytkownika</p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Użytkownik</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            <p>
                <label for="firstname">Imię</label>
                <input id="firstname" name="firstname" value="{$request->getPost('firstname')|default:''}" type="text" class="text small" />
                {validate check="notEmpty:#firstname" message='<span class="error">Nieprawidłowe imię</span>'}
            </p>
            
            <p>
                <label for="lastname">Nazwisko</label>
                <input id="lastname" name="lastname" value="{$request->getPost('lastname')|default:''}" type="text" class="text small" />
                {validate check="notEmpty:#lastname" message='<span class="error">Nieprawidłowe nazwisko</span>'}
            </p>
            
            <p>
                <label for="email">Email</label>
                <input id="email" name="email" value="{$request->getPost('email')|default:''}" type="text" class="text small" />
                {validate check="isEmail:#email" message='<span class="error">Nieprawidłowy adres email</span>'}
            </p>
            
            <p>
                <label for="province_id">Województwo</label>
                <select id="province_id" name="province_id" class="select">
                    {html_options options=$provinces selected=$request->getPost('province_id')|default:''}
                </select>
                {validate check="notEmpty:#province_id" message='<span class="error">Wybierz województwo</span>'}
            </p>
  
        	<p>
                <label for="new_pass">Hasło</label>
                <input id="new_pass" name="new_pass" value="" type="password" class="text small" />
                {validate check="notEmpty:#new_pass" message='<span class="error">Podaj hasło</span>'}
            </p>
            <p>
                <label for="confirm_pass">Powtórz hasło</label>
                <input id="confirm_pass" name="confirm_pass" value="" type="password" class="text small" />
                {validate check="equals:#new_pass:#confirm_pass" message='<span class="error">Hasła muszą być takie same</span>'}
            </p>
          
                
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" >Zapisz</button>
    <a href="{url a.action=index}" class="btn" >Powrót</a>
    
</form>
