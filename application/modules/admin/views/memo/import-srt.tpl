<h2>Słówka</h2>
<p>Import słowek</p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Import</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
        
             <p>
                <label for="content">Plik srt</label>
                <input type="file" name="file" />
             </p>

            {if $words}
            <table class="table table-bordered table-striped">
                <tbody>                      
                    {foreach from=$words key=k item=item}
                    {if $item}
                        <tr>
                           <td>{$item}</td>
                           <td>
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button class="btn btn-success">Known</button>
                                    <button class="btn btn-primary">To learn</button>
                                    <button class="btn active">Ignored</button>
                                </div>
                           </td>
                        </tr>
                    {/if}
                    {/foreach}
                </tbody>
            </table>
            {/if}
            
        </div>    
        
    </div> 
    
    <div>&nbsp;</div>
    <button class="btn btn-primary" type="submit" >{if $words}Zapisz{else}Wyczytaj plik{/if}</button>
    <a href="{url a.action=index a.id=null}" class="btn" >Powrót</a>
    
</form>