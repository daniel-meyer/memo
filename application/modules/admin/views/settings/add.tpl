<h2>Ustawienia</h2>
<p>Dodaj nową zmienną systemową
</strong></p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Nowa zmienna</a></li>
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
                <label for="name">Nazwa zmiennej</label>
                <br />
                <input id="name" name="name" value="{$request->getPost('name')}" type="text" class="text small" />
                {validate check="notEmpty:#name" message='<span class="error">Nieprawidłowa nazwa</span>'}
            </p>
            <p>
                <label for="value">Wartość</label>
                <textarea id="value" name="value" >{$request->getPost('value')}</textarea>
            </p>
            <p>
                <label for="section">Sekcja</label>
                <select id="section" name="section" class="select">
                    {html_options options=$tabs selected=$request->getPost('section')}
                </select>
            </p>
            <p>
                <label for="type">Rodzaj pola</label>
                <select id="type" name="type" class="select">
                    {html_options values=$types output=$types selected=$request->getPost('type')}
                </select>
            </p>
            <p>
                <label for="comments">Komentarz</label>
                <textarea id="comments" name="comments" >{$request->getPost('comments')}</textarea>
            </p>
            
            
            
        </div>
    </div> 
    
<div class="clearfix">&nbsp;</div>
<div class="grid_12"> 
    <input class="submit" value="Zapisz" type="submit" /><a href="{url a.action=index}" class="submit">Powrót</a>
</div>
    
</form>