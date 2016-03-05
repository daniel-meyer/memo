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
                <a class="navbar-brand" href="/">{$settings->siteTitle} - {$defaultUser->getFirstname()}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="admin">Login</a></li>
                    <li><a href="memo/last">Last added</a></li>
                    <li><a href="memo/last-failed">Last failed</a></li>
                    <li><a href="memo">Get started</a></li>

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
