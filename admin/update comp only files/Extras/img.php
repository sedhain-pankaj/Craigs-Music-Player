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

// Create FFMpeg instance once, reuse for all directories
$ffmpeg = FFMpeg\FFMpeg::create();

# Logistics for directory access to load video using opendir and readdir
# Use of FFMpeg to generate thumbnail images.
function img_gen($dir, $ffmpeg)
{
    $files = scandir($dir);
    $video_pattern = '/\.(mp4|m4v|mov|flv|ogv|webm|avchd|avi|mkv|wmv|mpg|mpeg)$/';

    foreach ($files as $filename) {
        if ($filename === '.' || $filename === '..' || $filename === '.DS_Store') continue;
        if (!preg_match($video_pattern, $filename)) continue;

        $filename_no_ext_img = preg_replace('/\.[^.]*$/', '', $filename);
        $thumbnail = $dir . 'img/' . $filename_no_ext_img . '.jpg';

        // Check if thumbnail exists BEFORE opening the video (skip the expensive part)
        if (file_exists($thumbnail)) {
            continue;
        }

        // Ensure img directory exists
        $img_dir = $dir . 'img';
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0755, true);
        }

        $sec = rand(5, 20);
        $movie = $dir . $filename;

        try {
            $video = $ffmpeg->open($movie);
            $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds($sec));
            $frame->save($thumbnail);
            echo $filename . ' thumbnail generated.' . PHP_EOL . PHP_EOL;
        } catch (Exception $e) {
            echo 'Error processing ' . $filename . ': ' . $e->getMessage() . PHP_EOL;
        }
    }
}


/* generate img */
$dirs = [
    $dir_5060, $dir_70, $dir_80, $dir_90, $dir_2000,
    $dir_LatestHits, $dir_Country, $dir_Karaoke,
    $dir_SpecialOccasion, $dir_ChristmasSong
];

foreach ($dirs as $dir) {
    img_gen($dir, $ffmpeg);
}

//First install php, composer and php/ffmpeg.
//Then run this file into terminal as 'php img.php'.
?>