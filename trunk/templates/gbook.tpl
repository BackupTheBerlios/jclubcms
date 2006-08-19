{include file="header.tpl" title="J-Club - G&auml;stebuch"}
{popup_init src="./overlib/overlib.js"}
<div id="contentContainer">
	<div id="content">

	<A href="mypage.html" {popup sticky=false caption="mypage contents"
text="<img src=http://localhost/phpmyadmin/themes/xampp/img/b_sqlhelp.png> Ein kleines Bild" snapx=10 snapy=10}>mypage</A><br />
	{$test_out}<br />
		{section name=gbook  loop=$guestbook}
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
		<tr>
		<td class="content_tab_header" colspan="2">
		{$guestbook[gbook].title}
		</td>
		</tr>
		<tr>
		<td class="content_tab_content1">
		{$guestbook[gbook].text}
		</td>
		<td class="content_tab_content2">
		<img src="style/icons/date.png" /> {$guestbook[gbook].datum}<br />
		<img src="style/icons/user.png" /> {$guestbook[gbook].name}<br />
		<a href="mailto:{$guestbook[gbook].mail}"><img src="style/icons/email.png" /> E-mail</a><br />
		<a href="{$guestbook[gbook].webpage}"><img src="style/icons/link.png" /> Website</a>
		</td>
		</tr>
		</table>
		{/section}
	</div>
</div>
{include file="footer.tpl" title=foo}
