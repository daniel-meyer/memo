<h2>Uprawnienia</h2>
<p>Edycja uprawnień dla roli: <strong>{$role->getName()}</strong></p>
<div class="clearfix">&nbsp;</div>

<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        <li><a href="#tab1">Strona główna</a></li>
        <li><a href="#tab2">Administracja</a></li>
    </ul>
    <div class="tab_container">
        <div id="tab1" class="tab_content">
            
            {foreach from=$resources item=item}
            {if $item->getModule()=='default'}
            <p>
              <label>{if $item->getComments()}{$item->getComments()}{else}{$item->getController()}{/if}</label>
        
                {foreach from=$item->getResourceActions()->toArray() item=it}<br />
                    <input type="checkbox" class="checkbox" value="{$it->getId()}" name="permissions[{$it->getId()}]" id="cb_{$it->getId()}" {if in_array($it->getId(), $permission_ids)}checked="1"{/if} />
                    <label class="normal" for="cb_{$it->getId()}">{$item->getModule()}/{$item->getController()}/{$it->getAction()}</label>
                    
                {/foreach}
                
            </p>
            {/if}
            {/foreach}
        </div>    
        
        <div id="tab2" class="tab_content">
            {foreach from=$resources item=item}
            {if $item->getModule()=='admin'}
            <p>
              <label>{if $item->getComments()}{$item->getComments()}{else}{$item->getController()}{/if}</label>
        
                {foreach from=$item->getResourceActions()->toArray() item=it}<br />
                    
                    <input type="checkbox" class="checkbox" value="{$it->getId()}" name="permissions[{$it->getId()}]" id="cb_{$it->getId()}" {if in_array($it->getId(), $permission_ids)}checked="1"{/if} />
                    <label class="normal" for="cb_{$it->getId()}">{$item->getModule()}/{$item->getController()}/{$it->getAction()}</label>
                    
                {/foreach}
              
              <br />
             
            </p>
            {/if}
            {/foreach}
        </div>    
    </div> 
    
<div class="clearfix">&nbsp;</div>
<div class="grid_12"> 
    <input class="submit" value="Zapisz" type="submit" /><a href="{url a.action=index a.id=null}" class="submit">Powrót</a>
</div>
    
</form>