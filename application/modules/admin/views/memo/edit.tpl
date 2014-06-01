<h2>Słówka</h2>
<p>Edycja słówka</p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Edycja</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
        
             <p>
                <label for="content">Question</label>
                <textarea name="question" id="question" style="height:200px">{$request->getPost('question')|default:$entity->getQuestion()}</textarea>
                {validate check="notEmpty:#question" message='<span class="error">Podaj question</span>'}
            </p>
            
            
            <p>
                <label for="answer">Answer</label>
                <textarea name="answer" id="answer" style="height:200px">{$request->getPost('answer')|default:$entity->getAnswer()}</textarea>

            </p>        
                
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" >Zapisz</button>
    <a href="{url a.action=index a.id=null}" class="btn" >Powrót</a>
    
</form>

