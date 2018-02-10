{doctype}
<html lang="{$lang}">
    {include file="head.tpl"}
 <body>
            
 <!-- Topbar -->

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">{$settings->siteTitle}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    {if $user->getId() == 1}<li><a href="admin">Admin</a></li>{/if}
                    <li {if $request->getActionName() == 'last'}class="active"{/if}><a href="memo/last">Last added</a></li>
                    <li {if $request->getActionName() == 'last-failed'}class="active"{/if}><a href="memo/last-failed">Last failed</a></li>
                    <li {if $request->getActionName() == 'index'}class="active"{/if}><a href="memo">New lesson</a></li>

                    <li role="presentation" class="dropdown">
                        <a href="#" class="dropdown-toggle" id="drop4" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Movies <span class="caret"></span></a>
                        <ul class="dropdown-menu" id="menu1" aria-labelledby="drop4">
                            {foreach from=$movies item=item}
                                 <li><a href="memo/date?date={$item->getSubmitDate()}">{$item->getTitle()}</a></li>
                            {/foreach}
                        </ul>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container theme-showcase" role="main">
        {include file="flash-message.tpl"}
        {layout attrib="content"} {* włączane podstrony *}


        <footer>&copy; 2013 Memo</footer>
    </div>
</body>
</html>
