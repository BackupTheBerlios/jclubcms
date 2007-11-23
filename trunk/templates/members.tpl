      <div id="content">
		<div id="content_txt">
            {foreach item=member from=$members}
            <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
              <tr>
                <td class="content_tab_header" colspan="2">
                {$member.members_ID}
                </td>
              </tr>
              <tr  class="content_tab_content1">
                <td>
                <a href="?nav_id={$image_link}&bild={$member.members_FIDimage}"><img src="?nav_id=41&thumb={$member.members_FIDimage}" /></a>
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
              	<td colspan="2" class="content_tab_content1"><a href="?mail&nav_id={$local_link}&entry_id={$member.members_ID}">Mail an {$member.members_spitzname}</a></td>
              </tr>
            </table>
            {/foreach}
	</div>
</div>
