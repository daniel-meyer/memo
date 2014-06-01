{if $messages}
    {foreach from=$messages item=item}
        <div class="alert
        {if substr($item,0,4)=='succ'}alert-success{/if}
    {if substr($item,0,4)=='info'}alert-info{/if}
{if substr($item,0,4)=='fail'}alert-error{/if}
{if substr($item,0,4)=='warn'}{/if}

">

    <a class="close" data-dismiss="alert">×</a>
    <strong>
    {if substr($item,0,4)=='succ'}Sukces!{/if}
{if substr($item,0,4)=='info'}Informacja:{/if}
{if substr($item,0,4)=='fail'}Błąd!{/if}
{if substr($item,0,4)=='warn'}Uwaga!{/if}
</strong> 
{$item|substr:5}

</div>


{/foreach}
{/if} 