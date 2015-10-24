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
                    <li><a href="admin">Login</a></li>
                    <li><a href="memo/last">Last added</a></li>
                    <li><a href="memo">Get started</a></li>

                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>



    {*<div class="container theme-showcase" role="main">*}
        {*{include file="flash-message.tpl"}*}
        {*{layout attrib="content"} *}{* włączane podstrony *}
    {*</div>*}


 <div class="container theme-showcase" role="main">

     <!-- Main jumbotron for a primary marketing message or call to action -->
     <div class="jumbotron">
         <h1>Theme example</h1>
         <p>This is a template showcasing the optional theme stylesheet included in Bootstrap. Use it as a starting point to create something more unique by building on or modifying it.</p>
     </div>


     <div class="page-header">
         <h1>Buttons</h1>
     </div>
     <p>
         <button type="button" class="btn btn-lg btn-default">Default</button>
         <button type="button" class="btn btn-lg btn-primary">Primary</button>
         <button type="button" class="btn btn-lg btn-success">Success</button>
         <button type="button" class="btn btn-lg btn-info">Info</button>
         <button type="button" class="btn btn-lg btn-warning">Warning</button>
         <button type="button" class="btn btn-lg btn-danger">Danger</button>
         <button type="button" class="btn btn-lg btn-link">Link</button>
     </p>
     <p>
         <button type="button" class="btn btn-default">Default</button>
         <button type="button" class="btn btn-primary">Primary</button>
         <button type="button" class="btn btn-success">Success</button>
         <button type="button" class="btn btn-info">Info</button>
         <button type="button" class="btn btn-warning">Warning</button>
         <button type="button" class="btn btn-danger">Danger</button>
         <button type="button" class="btn btn-link">Link</button>
     </p>
     <p>
         <button type="button" class="btn btn-sm btn-default">Default</button>
         <button type="button" class="btn btn-sm btn-primary">Primary</button>
         <button type="button" class="btn btn-sm btn-success">Success</button>
         <button type="button" class="btn btn-sm btn-info">Info</button>
         <button type="button" class="btn btn-sm btn-warning">Warning</button>
         <button type="button" class="btn btn-sm btn-danger">Danger</button>
         <button type="button" class="btn btn-sm btn-link">Link</button>
     </p>
     <p>
         <button type="button" class="btn btn-xs btn-default">Default</button>
         <button type="button" class="btn btn-xs btn-primary">Primary</button>
         <button type="button" class="btn btn-xs btn-success">Success</button>
         <button type="button" class="btn btn-xs btn-info">Info</button>
         <button type="button" class="btn btn-xs btn-warning">Warning</button>
         <button type="button" class="btn btn-xs btn-danger">Danger</button>
         <button type="button" class="btn btn-xs btn-link">Link</button>
     </p>
 </div>

</body>
</html>
