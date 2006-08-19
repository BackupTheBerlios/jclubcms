<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html 
		PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//DE"
		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
<head>
<title>{$title|capitalize}</title>
<link rel="stylesheet" href="./templates/style/style.css" type="text/css" /></head>
<body>
<div id="header">&nbsp;</div>
<div id="navigationContainer">
	<div id="navigation">
	{*Hier kommt die Navigation, ausgelesen aus der DB*}
	{section name=topnav loop=$nav}
	<a href="./index.php?nav_id={$nav[topnav].menu_ID}">{$nav[topnav].menu_name}</a>
	{/section}
	</div>
</div>
<div id="subnavContainer">
	<div id="subnav">
	{*Hier kommt die Navigation, ausgelesen aus der DB*}
	{section name=subnav loop=$subnav}
	<a href="./index.php?nav_id={$subnav[subnav].menu_ID}">{$subnav[subnav].menu_name}</a>
	{/section}
	</div>
</div>
