{*if $menu}   
<td class="leftmenu" width="210" align="left" valign="top"  style="height:{$menu_height}px">
<div class="menu_cont">

<!-- menu -->
{foreach from=$menu item=item}

{if !$item} </div>
{elseif $item eq 'blok'}<div class="mnu_blok  activ" >
{elseif $item eq 'hidden'}<div class="mnu_blok">

{else}
<div class="{$item.class}">
{if $item.link}<a href="{$item.link}" >{$item.name}&nbsp;</a>
{elseif $item.class eq 'menu'}<a href="admin/{$item.controller}/{if $item.action}{$item.action}/{/if}{$item.param}"  {if $item.activ}class="activ"{/if} >{$item.name}&nbsp;</a>
{else}{$item.name}&nbsp;{/if}

{/if}


{/foreach}


<!-- /menu -->     
</div>
<div style="padding-top:40px; padding-bottom:20px;">
<img src="public/images/admin/txt_cms_v41.jpg" alt="Etendard CMS" style="margin-bottom:7px;"/><br />
<img src="public/images/admin/txt_pomoc.gif" alt="Pomoc techniczna" /><br />
<img src="public/images/admin/txt_tel.gif" alt="Tel: (058)341-37-56" /><br />
<img src="public/images/admin/txt_help.gif" alt="helpdesk@etendard.pl, www.etendard.pl" /><br />
</div>
</td>
{/if*}

<div id="navigation" class=" grid_12">
    {*if $lang=='en'}
        <ul><li><a href="pl/admin" >PL</a></li></ul>
        <ul><li><a href="en/admin" class="active" >EN</a></li></ul>
    {else}
        <ul><li><a href="pl/admin" class="active" >PL</a></li></ul>
        <ul><li><a href="en/admin">EN</a></li></ul>
    {/if*}
    <ul>
        {foreach from=$aMenu item=item key=kij}
            <li>
            {if $item.link}<a id="menu_id{$kij}" href="{$item.link}"  {if $item.active}class="active"{/if} >{$item.name}</a>
    {else}<a id="menu_id{$kij}" href="javascript:void(0);"  {if $item.active}class="active"{/if} >{$item.name}</a>{/if}
</li>
{/foreach}
</ul>
</div>