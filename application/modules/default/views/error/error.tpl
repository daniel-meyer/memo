<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  
		<title>{$title}</title>
		<meta http-equiv="Content-Language" content="en" />
		<meta name="robots" content="none" />
        <base href="{serverUrl}{baseUrl}" />
        {literal}
		<style type="text/css">
			body {
				background-color:		#EEE;
			}

			#center {
				margin:							5em;
				padding:						2em;
				border:							1px solid #DDD;
				-moz-border-radius:	0.5em;
				background-color:		#FFF;
				font-family:				Verdana, Arial, sans-serif;
				line-height:				1.5em;
				font-size:					10pt;
			}

			h1 {
				margin:							0 0 1.5em 0;
			}

			h3 {
				margin:							2em 0 0 0;
			}

			.nice {
				margin:							1.5em 0 1.5em 1em;
				padding-left:				3.5em !important;
			}

			#message {
				font-weight:				bold;
				padding:						0.5em;
				-moz-border-radius:	0.5em;
				border:							1px solid #FB2;
				background-color:		#FFC;
				position:						relative;
			}

			#help {
				font-weight:				bold;
				padding:						0.5em;
				-moz-border-radius:	0.5em;
				border:							1px solid #66D;
				background-color:		#F0F0FF;
				position:						relative;
			}

			ol {
				font-size:					8pt;
				line-height:				1.5em;
			}

			li.hidecode ol {
				display:						none;
			}

			ol li {
				margin:							0 0 1em 0;
			}

			ol ol li {
				margin:							auto;
			}

			a.toggle:before {
				content:						'« ';
			}

			.hidecode a.toggle:before {
				content:						'';
			}

			.hidecode a.toggle:after {
				content:						' »';
			}

			ol ol {
				border:							1px solid #DDD;
				-moz-border-radius:	0.5em;
				font-family:				monospace;
				font-size:					10pt;
				line-height:				1em;
				min-height:					7em;
				padding-left:				auto;
				padding-top:				0.5em;
				padding-right:			0.5em;
				padding-bottom:			0.5em;
			}

			li.highlight code {
				background-color:		#EEE;
			}

			#svgDefinitions {
				width:							0;
				height:							0;
				overflow:						hidden;
			}

			abbr {
				border-bottom:			1px dotted #000;
				cursor:							help;
			}

			code {
				display:						block;
				margin:							0;
				padding:						0;
			}

			ol ol li {
				padding-left:				1em;
			}
		</style>
        {/literal}
	</head>
	<body>
	<div id="center">
		<div style="float:right; margin:-6em -6em 0 0; width:10em; height:10em">
            <img src="public/default/images/error/stop.png" alt="stop" />
        </div>
		
        <h1>{$title}</h1>
        
        {if $fixedTrace}
        
        {if $exception instanceof Zend_Exception}
		<div id="help" class="nice">
			<div style="position: absolute; top: -1.25em; left: -2em; height: 5em; width: 5em;">
                <img src="public/default/images/error/question.png" alt="question" />
            </div>
            <span>
			     This is an internal Zend Framework exception. Please consult the documentation for assistance with solving this issue.
            </span>
        </div>
        {else}
        <div id="help" class="nice">
			<div style="position: absolute; top: -1.25em; left: -2em; height: 5em; width: 5em;">
                <img src="public/default/images/error/question.png" alt="question" />
            </div>
            <span>
			     This is <em>not</em> a Zend Framework exception, but likely an error that occurred in the application code
            </span>
        </div>
        {/if}
        
		<p>An exception of type <strong>{$exception|@get_class}</strong> was thrown, but did not get caught during the execution of the request. You will find information provided by the exception along with a stack trace below.</p>
		
        
        
        <div id="message" class="nice">
			<div style="position: absolute; top: -1.25em; left: -2em; height: 5em; width: 5em;">
                <img src="public/default/images/error/warning.png" alt="warning" />
            </div>
            <span>{$exception->getMessage()}</span>		
        </div>
        {else}
        
         <div id="message" class="nice">
			<div style="position: absolute; top: -1.25em; left: -2em; height: 5em; width: 5em;">
                <img src="public/default/images/error/warning.png" alt="warning" />
            </div>
            <span>{$message}</span>		
        </div>
        {/if}
        
        
  {if $fixedTrace}      
  <h3>Stack trace:</h3>

    {$fixedTrace}
  {/if}
  
  {if $request}
  <h3>Request Parameters:</h3>
  <pre>{$request->getParams()|@var_export:1}
  </pre>
  {/if}


{if $zend_version}       
		<h3>Version Information</h3>
		<dl>
			<dt>Zend Framework:</dt>
			<dd>{$zend_version}</dd>
			<dt>PHP:</dt>
			<dd>{$phpversion}</dd>
			<dt>System:</dt>
			<dd>{$uname}</dd>
			<dt>Timestamp:</dt>
			<dd>{'c'|date}</dd>
		</dl>
{/if}    


<h3>Go to:</h3>
  
<a href="javascript:history.back()">back</a>
<a href="/">home</a>  
<a href="{url}">refresh</a>  
  
        </div>	
	</body>
</html>
