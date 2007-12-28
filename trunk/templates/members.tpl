      <div id="content">
		<div id="content_txt">
			<h1>Mitglieder</h1>
            {foreach item=member from=$members}
            <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
              <tr>
                <td class="content_tab_header" colspan="2">
                {$member.members_name}
                </td>
              </tr>
              <tr  class="content_tab_content1">
                <td>
                <a href="?{$param.nav_id}={$img_link}&bild={$member.members_FIDimage}"><img src="?{$param.nav_id}={$img_link}&thumb={$member.members_FIDimage}" /></a>
                </td>
                <td class="content_tab_content1">
                  Spitzname: {$member.members_spitzname}<br />
                  Geburtstag: {$member.members_birthday}<br />
                  Lieblingssong: {$member.members_song}<br />
			   Hobby: {$member.members_hobby}<br />
                  Beruf: {$member.members_job}<br />
                  Motto: {$member.members_motto}
                </td>
              </tr>
              <tr>
              	<td colspan="2" class="content_tab_content1"><a href="?mail&{$param.nav_id}={$local_link}&entry_id={$member.members_ID}">Mail an {$member.members_spitzname}</a></td>
              </tr>
            </table>
            {/foreach}
	</div>
</div>
