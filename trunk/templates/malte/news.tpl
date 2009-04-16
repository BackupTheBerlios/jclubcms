{config_load file="textes.de.conf" section="News"}
{foreach item=news  from=$newsarray}
<div class="news"> 
	<div class="newsheadline"> 
		<div class="newsdesign1"></div> 
		<div class="newsdesign2"><div style="padding-top: 18px;"><strong>{$news.news_title} </strong><small><small>{#at#} {$news.news_time}</small></small></div></div> 
		<div class="newsdesign3"></div> 
		<div class="newsdesign4"></div> 
		<div class="newsdesign5"></div> 
	</div> 
	<div class="newsinhalt"> 
		<div class="newsinhaltposition">
		{$news.news_content} <br /<br />
		<strong><small>von {$news.news_name} | <a href="?mail&nav_id={$local_link}&entry_id={$news.news_ID}">{#email#}</a> | {if $news.news_hp neq ""}<a href="http://{$news.news_hp}" target="_blank"> {#website#}</a>{/if}</small></strong>
		</div> 
	</div>

	<div class="newsende"></div> 
</div>
{/foreach}

<div><br /><br />
{foreach item=page from=$pages}
{if $page.link != ""}<a href="{$page.link}"> [{$page.page}] -</a>{else} [{$page.page}] -{/if}</a>
{/foreach}
</div>



