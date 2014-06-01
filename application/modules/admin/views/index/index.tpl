<!-- start icon dock-->
<div id="icondock" class="clearfix">

    <ul>
        {foreach from=$dashboard item=item}
            <li>
                <a href="{$lang}/{$item.link}" title="{$item.comments}" {if $item.facebox}rel="facebox"{/if}>
                    {if $item.icon}
                        <img src="public/admin/images/icondock/{$item.icon}.png" alt="{$item.name}" />
                    {/if}
                    <br />{$item.name}
                {if $item.amount}<span>{$item.amount}</span>{/if}
            </a>
        </li>
    {/foreach}

</ul>


</div><!-- end icon dock-->

<div class="row">

    <div id="notices" class="span4">

        <h2>Menu</h2>
        <ul class="tree">
            {if $showHome}
                <li class="tree_lvl1">
                    <a href="{$lang}/admin/module-home/index/pageid/{$root->getId()}">
                        <i class="icon-page icon-file"></i> <span>Strona główna</span>
                    </a>
                    <ul>
                        {include file="`$request->controller`/tree.tpl" pageItems=$pages}
                    </ul>
                </li>
            {else}
                {include file="`$request->controller`/tree.tpl" pageItems=$pages}
            {/if}
        </ul>
    </div>

    <!--  PLACEHOLDER FOR FLOT - REMOVE IF NOT REQUIRED -->
    <div class="span8">

        <h2>Statystyki odwiedzin</h2>

        <div id="placeholder" style="display:none;margin:auto">{$jsonStatystykaWejsc}</div> 

    </div>

</div>
