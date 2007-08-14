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
		{if isset($login_error)}
			<div style="error">
			{$login_error}
			</div>
		{/if}
		{$login_error}
		<br />TEst<br />
		<form action="{$file}" method="post" class="login_form">
			Benutzername: <input type="text" name="name" value="{$user}" /> <br />
			Passwort: <input type="password" name="password" /> <br />
			<input type="submit" name="login" value="Anmelden" />
			<input type="reset" name="Zur&uuml;cksetzen" />
		</form>
		
	</body>
</html>