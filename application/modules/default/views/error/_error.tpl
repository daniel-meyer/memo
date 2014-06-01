<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Zend Framework Default Application</title>
</head>
<body>
  <h1>An error occurred</h1>
  <h2>{$message}</h2>

  {if isset($exception)}

  <h3>Exception information:</h3>
  <p>
      <b>Message:</b> {$exception->getMessage()}
  </p>

  <h3>Stack trace:</h3>
  <pre>{$exception->getTraceAsString()}
  </pre>

  <h3>Request Parameters:</h3>
  <pre>{$request->getParams()|@var_export:1}
  </pre>
  {/if}


<a href="javascript:history.back()">Back to previous page</a>


<a href="/">Home page</a>

</body>
</html>