<h2>Ustawienia</h2>
<p>Edycja ustawień serwisu</p>


<form action="" method="post" enctype="multipart/form-data" >
    <ul class="tabs">
        {foreach from=$tabs item=tabName key=tabId}
            <li><a href="#tab{$tabId}">{$tabName}</a></li>
        {/foreach}
    </ul>
    <div class="tab_container">
        {foreach from=$tabs item=tabName key=tabId}
            <div id="tab{$tabId}" class="tab_content">
                {foreach from=$entities item=entity}
                    {if $entity->getSection()==$tabId && $entity->getIsVisible()}
                        <p>
                            <label for="{$entity->getName()}">{$entity->getTitle()}</label>
                        {if $entity->getComments()}<input type="button" class="tooltip help" title="{$entity->getComments()}" />{/if}
                        {if $entity->getType()=='textarea'}
                            <textarea id="{$entity->getName()}" name="{$entity->getName()}">{$entity->getValue()}</textarea>
                        {elseif $entity->getType()=='fck-editor'}
                            <textarea id="{$entity->getName()}" name="{$entity->getName()}" class="fckSimple" style="height:150px">{$entity->getValue()}</textarea>
                        {else}

                            <input id="{$entity->getName()}" name="{$entity->getName()}" value="{$entity->getValue()}" type="text"  class="text small" />
                        {/if}
                    </p>
                {/if}
            {/foreach}
        </div>
    {/foreach}       
</div> 
<div>&nbsp;</div>
<button class="btn btn-primary" type="submit" >Zapisz</button>
<a href="{$lang}/admin" class="btn" >Powrót</a>

</form>