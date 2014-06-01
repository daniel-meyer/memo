<!--<ul id="gallery-nav">
    {*foreach from=$galleryNav item=item key=key}
        <li><a href="{$item.url}" {if $key==$galleryNavActive}class="active"{/if}>{$item.name}</a></li>
    {/foreach*}
</ul>-->
{*$gallery|@print_r*}
{include file=sort.tpl}{* wymaga zmiennej array $cols *}
<table class="table table-striped">
<tbody>
<tr>
    <th>{'Photo'|translate}</th>
    <th>{'Title'|translate}</th>
    <th>{'Date'|translate}</th>
    <th>{'Contents'|translate}</th>
    <th>{'Status'|translate}</th>
    <th>{'Action'|translate}</th>
</tr>
{foreach from=$categories item=item}
<tr>

    <td><a href="{$lang}/admin/module-gallery/index/pageid/{$item->getId()}">{if $item->getLastPhoto()}<img src="{thumb file=$item->getLastPhoto()->getPhoto() width=150 height=150 mode=crop}" />{/if}</a></td>
	<td><h6><a alt="{$lang}/admin/module-gallery/index/pageid/{$item->getId()}" href="{$lang}/admin/module-gallery/index/pageid/{$item->getId()}">{$item->getMenuTitle()}</a></h6></td>
	<td>{$item->date}</td>
    <td>{$item->getContent()|textcut:250}</td>
    <td class="center">
            <a href="{url a.action='ajax-open' a.id=$item->getId() a.status=$item->getActive()}" title="Otwarte" class="tip ajaxStatus" >
                <i class="admin-sprite" style="background-position: {if $item->getActive()}-20px{else}0{/if} -120px;"></i>
            </a>
    </td>
    <td class="edit">
        <a href="{url a.action='edit' a.id=$item->getId()}" class="btn btn-mini btn-primary">Edytuj</a>
		<a href="{url a.action='delete' a.id=$item->getId()}" onClick="return(window.confirm('Czy na pewno chcesz skasować daną pozycję?'));" class="btn btn-mini btn-danger">Usuń</a>
	</td>
<tr>
{/foreach}
</tbody>
</table>
{*include file=pager.tpl*}{* wymaga zmiennej Zend_Paginator $paginator *}  