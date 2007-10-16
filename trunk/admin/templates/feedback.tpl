      <div id="content">
		<div id="content_txt">
		<table width = 100% class="content_tab">
		</table>
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="formailer_header" colspan="2">{$feedback_title}
			</td>
			</tr>
			<tr>
				<td class="formailer_options" colspan="2">{$feedback_content}</td>
			<tr>
				<td class="formailer_options" colspan="2">
                                {*Wenn im php-file angegeben, werden dateien in ein form gespeichert und so gesandt
                                Sonst gibt es ein stinknormaler link*}
                                {if $SEND_FORMS}
                                  <form action="{$feedback_link}" method="post" class="formailer_options">
                                    {foreach from=$form_array item=value key=name}
                                    <input type="hidden" name="{$name}" value="{$value}" />
                                    {/foreach}
                                    <input type="submit" name="weiter" value="{$feedback_linktext}" />
                                  </form>                                  
                                {else}
                                  <a href="{$feedback_link}">{$feedback_linktext}</a>
                                {/if}
                                </td>
			</tr>
		</table>
	</div>
</div>
