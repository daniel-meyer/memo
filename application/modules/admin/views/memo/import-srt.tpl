<h2>Słówka</h2>
<p>Import słowek</p>
<div class="clearfix">&nbsp;</div>

<script src="public/admin/scripts/memo.js"></script>
<form action="" method="post" enctype="multipart/form-data" id="memo-import-srt" >
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
            <div class="alert alert-info">
                Znaleziono: <strong>{$words|@count}</strong> nowych słówek
            </div>
            <table class="table table-bordered table-striped">
                <tbody>                      
                    {foreach from=$words key=k item=item}
                    {if $item}
                        <tr>
                           <td class="span3">{$item}</td>
                           <td class="span3">
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button class="btn btn-success btn-known">Known</button>
                                    <button class="btn btn-primary btn-to-learn">To learn</button>
                                    <button class="btn btn-ignored active">Ignored</button>
                                </div>
                           </td>
                           <td>
                               <input type="hidden" name="status[{$k}]" value="0" class="status">
                               <input type="hidden" name="question[{$k}]" value="{$item}" class="question">
                               <input type="text" name="answer[{$k}]" value="" class="answer hide">
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
    {if $words}
        <button class="btn btn-primary" type="submit" name="submit" value="save" >Zapisz</button>
    {else}
        <button class="btn btn-primary" type="submit" name="submit" value="load" >Wyczytaj plik</button>
    {/if}

    <a href="{url a.action=index a.id=null}" class="btn" >Powrót</a>
    
</form>