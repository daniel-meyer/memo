<thead>
<tr>
{foreach from=$cols item="col" key="coln"}
    {if $coln=='chb_all'}
        <th>
            <input type="checkbox" value="1" class="chb_all" />
        </th>
    {elseif substr($col,0,7)=='colspan'}
        <th colspan="{$col|@substr:7}">{$coln}</th>
    {elseif $col}
    	{if $sort==$col}
            {if $by=='desc'}
            <th onclick="window.location='{serverUrl}{url a.sort=$col a.by=asc}'" class="pointer header headerSortDown" >{$coln}</th>
            {else}
            <th onclick="window.location='{serverUrl}{url a.sort=$col a.by=desc}'" class="pointer header headerSortUp" >{$coln}</th>
            {/if}
        {else}
        <th onclick="window.location='{serverUrl}{url a.sort=$col a.by=asc}'" class="pointer header" >{$coln}</th>    
        {/if}
        
    {else}
        <th>{$coln}</th>
    {/if}
{/foreach}	
</tr>
</thead>