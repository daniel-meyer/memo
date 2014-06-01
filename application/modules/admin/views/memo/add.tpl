<h2>Słówka</h2>
<p>Dodanie nowego słówka</p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Nowe słówko</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
       
  
            <p>
                <label for="content">Question</label>
                <textarea name="question" id="question" class="fck" style="height:200px">{$request->getPost('question')}</textarea>
                {validate check="notEmpty:#question" message='<span class="error">Podaj question</span>'}
            </p>
            
            
            <p>
                <label for="answer">Answer</label>
                <textarea name="answer" id="answer" class="fck" style="height:200px">{$request->getPost('answer')}</textarea>
            </p>
            
            
            {*}
            <p>
                <label for="publish_date">Data publikacji</label>
                <input id="publish_date" name="publish_date" value="{$request->getPost('publish_date')|default:'now'|format:'Y-m-d'}" class="datepicker span2" type="text" />
                
            </p>{*}

                  
                
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" >Zapisz</button>
    <a href="{url a.action=index}" class="btn" >Powrót</a>
    
</form>

