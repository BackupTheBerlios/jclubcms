{config_load file="textes.de.conf" section="Feedback"}      
	<div id="content">
		<div id="content_txt">
		<table width = 100% class="content_tab">
		</table>
		<table cellpadding="0" cellspacing="0" align="center" class="content_tab">
			<tr>
			<td class="formailer_header" colspan="2">{$feedback_title|default:#feedback#}
			</td>
			</tr>
			<tr>
				<td class="formailer_options" colspan="2">{$feedback_content}</td>
			<tr>
				<td class="formailer_options" colspan="2">               
                     <a href="{$feedback_link|default:"?"}&{$SID}">{$feedback_linktext|default:#forward#}</a>
				</td>
			</tr>
		</table>
	</div>
</div>
