<h2>Słówka</h2>
<p>Dodanie nowego słówka</p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Import</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
       
  
            <p>
                <label for="content">Content</label>
                <textarea name="content" id="content" style="height:500px">{$request->getPost('content')}</textarea>
                {validate check="notEmpty:#content" message='<span class="error">Podaj content</span>'}
            </p>
            
         
            <p>
                <label for="separator">Separator</label>
                <input id="separator" name="separator" value="{$request->getPost('separator')|default:', '}" class="span1" type="text" />
                {validate check="isSeparator:#separator" message='<span class="error">Podaj separator</span>'}
                
            </p>

                  
                
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" >Importuj</button>
    <a href="{url a.action=index}" class="btn" >Powrót</a>
    
</form>

