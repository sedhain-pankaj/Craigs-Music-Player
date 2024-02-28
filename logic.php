<?php

//Directory link variables
$dir_array = [
    'music/Fifty Sixty/',
    'music/Seventy/',
    'music/Eighty/',
    'music/Ninety/',
    'music/2000/',
    'music/Latest Hits/',
    'music/Country/',
    'music/Karaoke/',
    'music/Special Occasion/',
    'music/Christmas Song/'
];

//variable to store the index number for the table
$index = 1;

# Directory access to load video using opendir and readdir
function img_video_loader($dir, $index)
{
    $files = scandir($dir);
    $filtered_files = array_filter($files, function ($filename) {
        return $filename !== '.'
            && $filename !== '..'
            && $filename !== '.DS_Store'
            && preg_match('/\.(mp4|m4v|mov|flv|ogv|webm|avchd|avi|mkv|wmv|mpg|mpeg)$/', $filename);
    });

    foreach ($filtered_files as $filename) {
        //filename without extension
        $filename_no_ext = preg_replace('/\.[^.]*$/', '', $filename);

        //thumbnail, image and directory variables passed to queue_array_create
        $thumbnail = $dir . 'img/' . $filename_no_ext . '.jpg';
        $img = '<img src="' . $thumbnail . '" alt="' . $filename . '">';
        $dir_link = $dir . $filename;

        //display index number, thumbnail and filename
        echo
        '<table onclick="javascript:queue_array_create(\'' . $filename_no_ext . '\' , \'' . $thumbnail . '\' , \'' . $dir_link . '\')"">    
                    <th id="index">' . $index++ . '.</th>
                    <th>' . $img . '</th>
                    <td>' . $filename_no_ext . '</td>
            </table>';
    }
}


// shuffles songd randomly for a particular directory
function shuffle_img_video_loader($dir)
{
    $files = scandir($dir);
    $filtered_files = array_filter($files, function ($filename) {
        return $filename !== '.'
            && $filename !== '..'
            && $filename !== '.DS_Store'
            && preg_match('/\.(mp4|m4v|mov|flv|ogv|webm|avchd|avi|mkv|wmv|mpg|mpeg)$/', $filename);
    });

    foreach ($filtered_files as $file) {
        echo $dir . $file . '<br>';
    }
}

//keys for $_GET in ajax call in songs.js
$valid_keys = [
    '5060' => 0,
    '70' => 1,
    '80' => 2,
    '90' => 3,
    '2000' => 4,
    'LatestHits' => 5,
    'Country' => 6,
    'Karaoke' => 7,
    'SpecialOccasion' => 8,
    'ChristmasSong' => 9,
];

//load the video by directory 
foreach ($_GET as $key => $value) {
    if (array_key_exists($key, $valid_keys) && array_key_exists($valid_keys[$key], $dir_array)) {
        img_video_loader($dir_array[$valid_keys[$key]], $index);
    }
}

//keys for $_GET in ajax call in shuffle.js linked to valid_keys
$shuffle_keys = array_map(function ($key) {
    return 'shuffle_' . $key;
}, array_keys($valid_keys));

//shuffle the video by directory
foreach ($_GET as $key => $value) {
    if (in_array($key, $shuffle_keys) && array_key_exists($valid_keys[str_replace('shuffle_', '', $key)], $dir_array)) {
        shuffle_img_video_loader($dir_array[$valid_keys[str_replace('shuffle_', '', $key)]]);
    }
}
