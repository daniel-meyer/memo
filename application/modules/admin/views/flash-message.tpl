{if $messages}
    {foreach from=$messages item=item}
    <div class="notification {$item|substr:0:4} canhide">
      <p><strong>
          {if substr($item,0,4)=='succ'}SUKCES:{/if}
          {if substr($item,0,4)=='info'}INFORMACJA:{/if}
          {if substr($item,0,4)=='fail'}BŁĄD:{/if}
          {if substr($item,0,4)=='warn'}UWAGA:{/if}
       </strong> {$item|substr:5}</p>
	</div>
    {/foreach}
{/if}    