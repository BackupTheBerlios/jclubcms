      <div id="content">
		<div id="content_txt">
			<h1>{#members#}</h1>
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
                  {#nickname#}: {$member.members_spitzname}<br />
                  {#birthday#}: {$member.members_birthday}<br />
                  {#favorite_song#}: {$member.members_song}<br />
			   {#hobby#}: {$member.members_hobby}<br />
                  {#job#}: {$member.members_job}<br />
                  {#motto#}: {$member.members_motto}
                </td>
              </tr>
              <tr>
              	<td colspan="2" class="content_tab_content1"><a href="?mail&{$param.nav_id}={$local_link}&entry_id={$member.members_ID}">{#mail_to#} {$member.members_spitzname}</a></td>
              </tr>
            </table>
            {/foreach}
	</div>
</div>
