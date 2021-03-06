<?xml version="1.0" encoding="ISO-8859-1" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>{$title|default:"JClub-Administration"}</title>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link rel="stylesheet" type="text/css" href="./{$TEMPLATESET_DIR}/style/style.css">
		<script type="text/javascript" language="javascript">
function focus(){ldelim}document.login.name.focus(); {rdelim}
</script>
	{config_load file="textes.de.conf" section="login"}
	</head>
	<body onload="focus()">
		<div id="header">&nbsp;</div>
		<div id="content" style="text-align: center">
			
			<form action="{$file}" name="login" method="post">
				<table class="content_formailer">
					{if isset($login_error)}
					<tr>
						<td style="background-color: #DF7B00">{$login_error}</td>
					</tr>
					{/if}
					<tr>
						<td  class="formailer_header">{#login_for_admin#}</td>
					</tr>
					<tr>
						<td class="formailer_adress">{#username#}: <input class="formailer_adress_input" tabindex="1" type="text" name="name" value="{$user}" /></td>
					</tr>
					<tr>
						<td class="formailer_adress">{#password#}: <input class="formailer_adress_input" tabindex="2" type="password" name="password" /></td>
					</tr>
					<tr>
						<td class="formailer_adress">
							<input type="submit" name="login" value="{#login#}" />
							<input type="reset" name="{#undo#}" />
						</td>
					</tr>
				</table>
			</form>
		</div>		
	</body>
</html>