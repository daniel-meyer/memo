{foreach from=$pageItems item=item}
    <li class="tree_lvl{$item.page->getLvl()}">
        <a 
            {if $item.page->getType()=='module' && $item.page->getModule()!='container'}href="{$lang}/admin/module-{$item.page->getModule()}/index/pageid/{$item.page->getId()}"
        {else}href="javascript:;"{/if} 
        >
        <i class="icon-page icon-file"></i>{*}icon-{$item.page->getModule()}{*}
        <span>{$item.page->getMenuTitle()|textcut:40}</span>
    </a>

    {if $item.children}
        <ul>
            {include file="`$request->controller`/tree.tpl" pageItems=$item.children}
        </ul>
    {/if}
</li>
{/foreach}