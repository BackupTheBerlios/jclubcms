<?xml version="1.0" encoding="ISO-8859-1" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>{$title|default:"JClub-Administration"}</title>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link rel="stylesheet" type="text/css" href="./templates/style/style.css">
	</head>
	<body>
		<div id="header">&nbsp;</div>
		<div id="error" style="text-align: center">
			{$error_text}<br />
			<a href="{$error_link|default:"index.php"}">{$error_linktext|default:"Login"}</a>
		</div>		
	</body>
</html>