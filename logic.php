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

// Video file extension pattern (compiled once, reused everywhere)
define('VIDEO_PATTERN', '/\.(mp4|m4v|mov|flv|ogv|webm|avchd|avi|mkv|wmv|mpg|mpeg)$/');

// Cache directory listing to avoid repeated filesystem scans
// Returns filtered video files for a directory, cached for 5 minutes
function get_video_files($dir)
{
    $cache_dir = __DIR__ . '/cache';
    if (!is_dir($cache_dir)) {
        mkdir($cache_dir, 0755, true);
    }

    $cache_file = $cache_dir . '/' . md5($dir) . '.json';
    $cache_ttl = 300; // 5 minutes

    if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $cache_ttl) {
        return json_decode(file_get_contents($cache_file), true);
    }

    $files = scandir($dir);
    $filtered_files = [];
    foreach ($files as $filename) {
        if (
            $filename !== '.' && $filename !== '..' && $filename !== '.DS_Store'
            && preg_match(VIDEO_PATTERN, $filename)
        ) {
            $filtered_files[] = $filename;
        }
    }

    file_put_contents($cache_file, json_encode($filtered_files));
    return $filtered_files;
}

# Directory access to load video using opendir and readdir
function img_video_loader($dir, $index)
{
    $filtered_files = get_video_files($dir);
    $html = '';

    foreach ($filtered_files as $filename) {
        $filename_no_ext = preg_replace('/\.[^.]*$/', '', $filename);
        $thumbnail = $dir . 'img/' . $filename_no_ext . '.jpg';
        $dir_link = $dir . $filename;

        // Build HTML in a buffer instead of echoing one at a time
        $html .= '<table onclick="queue_array_create(\'' . $filename_no_ext . '\' , \'' . $thumbnail . '\' , \'' . $dir_link . '\')">'
            . '<th id="index">' . $index++ . '.</th>'
            . '<th><img src="' . $thumbnail . '" alt="' . $filename . '"></th>'
            . '<td>' . $filename_no_ext . '</td>'
            . '</table>';
    }

    echo $html;
}


// shuffles songs randomly for a particular directory
function shuffle_img_video_loader($dir)
{
    $filtered_files = get_video_files($dir);

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

// Build a lookup set for shuffle keys (isset() is O(1) vs in_array() O(n))
$shuffle_lookup = [];
foreach (array_keys($valid_keys) as $k) {
    $shuffle_lookup['shuffle_' . $k] = $k;
}

// Single loop over $_GET instead of two separate loops
foreach ($_GET as $key => $value) {
    if (array_key_exists($key, $valid_keys) && array_key_exists($valid_keys[$key], $dir_array)) {
        img_video_loader($dir_array[$valid_keys[$key]], $index);
    } elseif (isset($shuffle_lookup[$key])) {
        $base_key = $shuffle_lookup[$key];
        if (array_key_exists($valid_keys[$base_key], $dir_array)) {
            shuffle_img_video_loader($dir_array[$valid_keys[$base_key]]);
        }
    }
}
