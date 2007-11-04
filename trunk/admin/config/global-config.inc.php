<?php

/**
 * @package JClubCMS
 * @author David Daester, Simon D�ster
 */

/*DB-Einstellungen*/
$db_server = "localhost";
$db_name = "jclubbeta";
$db_user = "jclubbeta";
$db_pw ="jclubbeta";

//**Bild und Thumb

//!!! Bilder sind stdmaessig in originals abgespeichert, aber wenn sie zu gross sind, in gallery
$dir_orgImage = USER_DIR."graphics/originals/"; //Relativ zur Index-Datei
$dir_galImage = USER_DIR."graphics/gallery/";  //Relativ zur Index-Datei
$image_maxheight = 600;
$image_maxwidth = 600;

$dir_thumb = USER_DIR."graphics/gallery/thumbs/";  //Relativ zur Index-Datei
$thumb_maxheight = 150;
$thumb_maxwidth = 150;

//**Smilies
$dir_smilies = USER_DIR."graphics/smilies/";

?>