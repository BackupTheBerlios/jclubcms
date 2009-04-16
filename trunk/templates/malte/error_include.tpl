{config_load file="textes.de.conf"}
  <div id="content">
	<div id="content_txt">
          <table class="error_tab" style="text-align: center">
			<tr class="error_tab_header">
				<td>{$error_title}</td>
			</tr>
			<tr class="error_tab_content">
				<td>
				{$error_text}<br />
				<a href="{$error_link|default:"?"}">{$error_linktext|default:#home#}</a>
				</td>
			</tr>
		</table>
      </div>
</div>