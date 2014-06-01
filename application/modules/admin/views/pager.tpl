{if $paginator->getPages()->pageCount>1}
<div class="clearfix">
<ul id="pagination">
   <!-- Previous page link -->
{if $paginator->getPages()->previous}
  <li class="previous"><a href="{url a.page=$paginator->getPages()->previous}">
    &lt; Poprzednia
  </a></li>
{else}
    <li class="previous-off">&lt; Poprzednia</li>
{/if}

{if $paginator->getPages()->firstPageInRange > 1}
    <li><a href="{url a.page=1}">1</a></li>
    {if $paginator->getPages()->firstPageInRange > 2}
        <li class="disabled"><a href="javascript:;">...</a></li>
    {/if}
{/if}

<!-- Numbered page links -->
{foreach from=$paginator->getPages()->pagesInRange item=paginator_page}
    {if $paginator_page != $paginator->getPages()->current}
        <li>
            <a href="{url a.page=$paginator_page}">
                {$paginator_page}
            </a>
        </li>
    {else}
        <li class="active">{$paginator_page}</li>
    {/if}
{/foreach}

{if $paginator->getPages()->lastPageInRange!=$paginator->getPages()->pageCount}
    {if $paginator->getPages()->lastPageInRange!=$paginator->getPages()->pageCount-1}
        <li class="disabled"><a href="javascript:;">...</a></li>
    {/if}
    <li><a href="{url a.page=$paginator->getPages()->pageCount}">{$paginator->getPages()->pageCount}</a></li>
{/if}

<!-- Next page link -->
{if $paginator->getPages()->next}
    <li class="next">
        <a href="{url a.page=$paginator->getPages()->next}">
            Następna &gt;
        </a>
    </li>
{else}
  <li class="next-off">Następna &gt;</li>
{/if}
</ul>


</div>  
{/if}

        