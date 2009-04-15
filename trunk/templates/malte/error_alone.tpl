<?xml version="1.0" encoding="ISO-8859-1" ?>
{config_load file="textes.de.conf"}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
       "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>{$title|default:#main_title#}</title>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link rel="stylesheet" type="text/css" href="./{$TEMPLATESET_DIR}/style/style.css">
	</head>
	<body>
		<table class="error_tab" style="text-align: center">
			<tr class="error_tab_header">
				<td>{$error_title|default:"Fehler"}</td>
			</tr>
			<tr class="error_tab_content">
				<td>
				{$error_text}<br />
				<a href="{$error_link|default:""}">{$error_linktext|default:#home#}</a>
				</td>
			</tr>
		</table>		
	</body>
</html>