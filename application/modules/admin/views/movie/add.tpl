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
                <label for="title">Tytuł</label>
                <br />
                <input id="title" name="title" value="{$request->getPost('title')}" type="text" class="text small" />
                {validate check="notEmpty:#title" message='<span class="error">Nieprawidłowy tytuł</span>'}
            </p>



            <p>
                <label for="submit_date">Data</label>
                <br />
                <input id="submit_date" name="submit_date" value="{$request->getPost('submit_date')|default:'now'|format:'Y-m-d'}" class="datepicker span2" type="text" />
                {validate check="notEmpty:#submit_date" message='<span class="error">Nieprawidłowa data</span>'}
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

