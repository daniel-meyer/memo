{doctype}
<html lang="{$lang}">

    {include file="head.tpl"}
{literal}
<style>
html, body {
	height: 100%;
}
.quickstart {
	min-height: 100%;
	height: auto !important;
	height: 100%;
	margin: 0 auto -20px; /* the bottom margin is the negative value of the footer's height */
}
footer, .push {
	height: 20px; /* .push must be the same height as .footer */
}
footer p {
	margin: 0;
}
.container, .navbar-fixed-top .container, .navbar-fixed-bottom .container {
    width: auto;
	max-width: 940px;
}
</style>
{/literal}
 <body>
            
    <!-- Topbar -->
    
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">

          <a href="/" class="brand">{$settings->siteTitle}</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="">
                <a href="admin">Logowanie</a>
              </li>
              <!-- <li class="active">
                <a href="./getting-started.html">Get started</a>
              </li>
               -->
            </ul>
          </div>
        </div>
      </div>
    </div>
           


    <div class="quickstart" >
          <div class="container" style="padding-top:40px;">
            <div class="row">
                        {include file="flash-message.tpl"}
                        {layout attrib="content"} {* włączane podstrony *}
            </div><!-- /row -->
          </div>
		  <div class="push"></div>
    </div>
    
    <footer>
		<div class="container">
        <p>&copy; 2013 Memo</p>
        </div>
    </footer>    
    
   
</body>
</html>
