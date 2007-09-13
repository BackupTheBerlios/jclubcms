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
		<div id="content" style="text-align: center">
			
			<form action="{$file}" method="post">
				<table class="content_formailer">
					{if isset($login_error)}
					<tr>
						<td style="background-color: #DF7B00">{$login_error}</td>
					</tr>
					{/if}
					<tr>
						<td  class="formailer_header">Anmeldung f&uuml;r die Administration</td>
					</tr>
					<tr>
						<td class="formailer_adress">Benutzername: <input class="formailer_adress_input" tabindex="1" type="text" name="name" value="{$user}" /></td>
					</tr>
					<tr>
						<td class="formailer_adress">Passwort: <input class="formailer_adress_input" tabindex="2" type="password" name="password" /></td>
					</tr>
					<tr>
						<td class="formailer_adress">
							<input type="submit" name="login" value="Anmelden" />
							<input type="reset" name="Zur&uuml;cksetzen" />
						</td>
					</tr>
				</table>
			</form>
		</div>		
	</body>
</html>