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


# Logistics for directory access to load video using opendir and readdir
# Use of FFMpeg of generate thumbnail images.
function img_gen($dir)
{
    $videodir = opendir($dir);
    while (false !== ($filename = readdir($videodir))) {
        if ('.' !== $filename && '..' !== $filename && '.DS_Store' !== $filename && preg_match('/\.(mp4|m4v|mov|flv|ogv|webm|avchd|avi|mkv|wmv|mpg|mpeg)$/', $filename)) {

            //var to store filename without extension for thumbnail image
            $filename_no_ext_img = preg_replace('/\.[^.]*$/', '', $filename);
            $thumbnail = $dir . 'img/' . $filename_no_ext_img . '.jpg';

            //generate random number between 5 and 20 
            $sec = rand(5, 20);
            $movie = $dir . '/' . $filename;

            # ext php func called FFMpeg installed using composer
            $ffmpeg = FFMpeg\FFMpeg::create();
            $video = $ffmpeg->open($movie);
            $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
            //if thumbnail already exists, skip.
            if (file_exists($thumbnail)) {
                continue;
            } else {
                $frame->save($thumbnail);
                echo $filename . ' thumbnail generated.' . PHP_EOL . PHP_EOL;

            }
        }
    }
    closedir($videodir);
}


/* generate img */
img_gen($dir_5060);
img_gen($dir_70);
img_gen($dir_80);
img_gen($dir_90);
img_gen($dir_2000);
img_gen($dir_LatestHits);
img_gen($dir_Country);
img_gen($dir_Karaoke);
img_gen($dir_SpecialOccasion);
img_gen($dir_ChristmasSong);

//First install php, composer and php/ffmpeg.
//Then run this file into terminal as 'php img.php'.
?>