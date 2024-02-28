<?php
//Link to composer depenedencies called php/FFMPEG.php
require 'vendor/autoload.php';

//Directory link variables
$dir_5060 = '../music/Fifty Sixty/';
$dir_70 = '../music/Seventy/';
$dir_80 = '../music/Eighty/';
$dir_90 = '../music/Ninety/';
$dir_2000 = '../music/2000/';
$dir_LatestHits = '../music/Latest Hits/';
$dir_Country = '../music/Country/';
$dir_Karaoke = '../music/Karaoke/';
$dir_SpecialOccasion = '../music/Special Occasion/';
$dir_ChristmasSong = '../music/Christmas Song/';



function title($dir)
{
    $videodir = opendir($dir);
    while (false !== ($filename = readdir($videodir))) {
        if ('.' !== $filename && '..' !== $filename && '.DS_Store' !== $filename && preg_match('/\.(mp4|m4v|mov|flv|ogv|webm|avchd|avi|mkv|wmv|mpg|mpeg)$/', $filename)) {

            //if filename contains apostrophe, remove it using rename function
            if (strpos($filename, "'") !== false) {
                rename($dir . $filename, $dir . str_replace("'", "", $filename));
            }
        }
    }
    closedir($videodir);
}


/* check for apostrophe in title */
title($dir_5060);
title($dir_70);
title($dir_80);
title($dir_90);
title($dir_2000);
title($dir_LatestHits);
title($dir_Country);
title($dir_Karaoke);
title($dir_SpecialOccasion);
title($dir_ChristmasSong);

//First install php, composer and php/ffmpeg.
//Then run this file into terminal as 'php title.php'.
?>