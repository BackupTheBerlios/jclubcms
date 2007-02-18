      <div id="content">
		<div id="content_txt">
            {foreach key=index item=name from=$name}
            <table cellpadding="0" cellspacing="0" align="center" class="content_tab">
              <tr>
                <td class="content_tab_header" colspan="2">
                {$name}
                </td>
              </tr>
              <tr  class="content_tab_content1">
                <td>
                <a href="./index.php?nav_id=40&pic={$IDimage.$index}"><img src="./index.php?nav_id=41&thumb={$IDimage.$index}" /></a>
                </td>
                <td class="content_tab_content1">
                  Spitzname: {$spitzname.$index}<br />
                  Geburtstag: {$birthday.$index}<br />
                  Lieblingssong: {$song.$index}<br />
                  Beruf: {$job.$index}<br />
                  Motto: {$motto.$index}
                </td>
              </tr>
              <tr>
              	<td colspan="2" class="content_tab_content1"><a href="?nav_id={$local_link}&action=mail&entry_id={$ID.$index}">Mail an {$spitzname.$index}</a></td>
              </tr>
            </table>
            {/foreach}
	</div>
</div>
