<?php
include 'logic.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Craig Williams JukeBox</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Craig Williams JukeBox">
    <meta property="og:title" content="Craig Williams JukeBox">
    <meta name="author" content="psedha10">
    <meta name="owner" content="craigw@craigwilliams.com.au">
    <meta name="og:country-name" content="Aussie">

    <!-- libaries and jQuery UI css-->
    <link rel="stylesheet" type="text/css" href="/CSS/sidenav.css">
    <link rel="stylesheet" type="text/css" href="/CSS/keyboard.css">
    <link rel="stylesheet" type="text/css" href="/jquery-framework/jquery-ui.css">

    <!-- jQuery -->
    <script src="/jquery-framework/external/jquery/jquery.js" type="text/javascript"></script>
    <script src="/jquery-framework/jquery-ui.js" type="text/javascript"></script>

    <!-- local css -->
    <link rel="stylesheet" type="text/css" href="/CSS/style.css">
    <link rel="stylesheet" type="text/css" href="CSS/left-block.css">
    <link rel="stylesheet" type="text/css" href="CSS/top-middle-block.css">
    <link rel="stylesheet" type="text/css" href="CSS/bottom-middle-block.css">
    <link rel="stylesheet" type="text/css" href="CSS/right-block-search.css">
    <link rel="stylesheet" type="text/css" href="CSS/right-block-scroll.css">

    <!-- local js -->
    <script src="/index.js" type="text/javascript"></script>
    <script src="/JS/youtube.js" type="text/javascript"></script>
    <script src="/JS/queue.js" type="text/javascript"></script>
    <script src="/JS/songs.js" type="text/javascript"></script>
    <script src="/JS/shuffle.js" type="text/javascript"></script>
    <script src="/JS/delete.js" type="text/javascript"></script>
    <script src="/JS/search.js" type="text/javascript"></script>
    <script src="/JS/keyboard.js" type="text/javascript"></script>
    <script src="/JS/skip.js" type="text/javascript"></script>
    <script src="/JS/scrollbar.js" type="text/javascript"></script>
    <script src="/JS/modal.js" type="text/javascript"></script>
    <script src="/JS/config.js" type="text/javascript"></script>

    <!-- Google Material UI -->
    <link href="/CSS/materialUI-icons.css" rel="stylesheet">

    <!-- mediaelement JS -->
    <script src="/JS/mejs.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/CSS/mejs.css">

</head>

<body>

    <!-- left division for categories button -->
    <div class="left-block">
        <!-- randomizer container buttons -->
        <?php
        $categories_shuffle = [
            "shuffle_5060" => "50's + 60's",
            "shuffle_70" => "70's",
            "shuffle_80" => "80's",
            "shuffle_90" => "90's",
            "shuffle_2000" => "2000's",
            "shuffle_LatestHits" => "Latest Hits",
            "shuffle_Country" => "Country",
            "shuffle_SpecialOccasion" => "Special Occasion",
            "shuffle_ChristmasSong" => "Christmas Song"
        ];
        ?>

        <div id="mySidenav" class="sidenav">
            <a class="closebtn" onclick="closeNav()">&times;</a>
            <?php foreach ($categories_shuffle as $id => $name) : ?>
                <a id="<?= $id ?>"><?= $name ?></a><br>
            <?php endforeach; ?>
        </div>


        <!-- left block buttons section -->
        <div class="buttons_leftblock">
            <!-- shuffle -->
            <span class='span-heading'> Shuffle: </span>
            <button class="button-randomizer" id="randomizer" onclick="openNav()" style="margin-bottom: 0.5vw;">
                <i class="material-icons" style="font-size:clamp(1vw, 2vw, 3vw); margin-right:1vw;">menu</i>
                Randomizer
                <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); margin-left:0.4vw; color:#4100f4;">change_circle</i>
            </button>

            <!-- categories -->
            <span class='span-heading'> Categories: </span>
            <?php
            $categories = [
                "5060" => "50's + 60's",
                "70" => "70's",
                "80" => "80's",
                "90" => "90's",
                "2000" => "2000's",
                "LatestHits" => "Latest Hits",
                "Country" => "Country",
                "Karaoke" => "Karaoke",
                "SpecialOccasion" => "Special Occasion",
                "ChristmasSong" => "Christmas Song"
            ];
            ?>

            <?php foreach ($categories as $id => $name) : ?>
                <button class="button-left" id="<?= $id ?>"><?= $name ?></button>
            <?php endforeach; ?>

            <!-- youtube -->
            <span class='span-heading' style="margin-top: 0.5vw;"> YouTube: </span>
            <button class="button-yt" onclick="search_youtube()">
                <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); margin-right:1vw; color:brown;">smart_display</i>
                YouTube Search
            </button>
        </div>


        <!-- left block volume top section -->
        <div class="volume_leftblock">
            <div class="volume-upper-section">
                <div class="volume-digit">
                    Volume:
                    <span id="vol">50</span>
                </div>
                <i class="material-icons" id="mute">volume_up</i>
            </div>
            <!-- volume bottom section -->
            <div class="volume-lower-section">
                <!-- jQuery UI slider for volume -->
                <button id="vol_down">
                    <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); position: absolute">do_not_disturb_on</i>
                </button>
                <button id="vol_up">
                    <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); position: absolute">add_circle</i>
                </button>
                <div id="slider"></div>
            </div>
        </div>

    </div>




    <!-- bottom middle division for video playback -->
    <!-- switched with center-section. div id not changed -->
    <div class="bottom-middle-block" id="bottom-middle-block">

        <div id="skip_button_div">
            <button id="skip_button">
                Skip
                <i class="material-icons" style="font-size:clamp(1vw, 1.5vw, 2vw); color:blueviolet;">skip_next</i>
            </button>
        </div>

        <div id="video_title_div">
            <h4 id="video_title">Video Title</h4>
        </div>

        <div id="video_container">
            <video id="video" src="" autoplay preload="auto"></video>
        </div>
    </div>




    <!-- right division for songs in queue -->
    <div class="right-block">

        <!-- main right block 1st subsection : right-search -->
        <div class="right-search">

            <!-- right-search header section -->
            <div id="search_header">
                <span>
                    Search
                    <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); margin-left:0.3vw; color:#004230;">content_paste_search</i>
                </span>
            </div>

            <!-- right-search search section -->
            <div id="right-block-search">
                <!-- select-section -->
                <div class="select-div">
                    <select id="select">
                        <option value="all" selected> All Songs </option>
                        <option value="karaoke"> Karaoke </option>
                    </select>
                </div>
                <!-- input section shown based on selected option -->
                <div class="input-div">
                    <input type="text" id="search_all" placeholder="Search All Songs" autocomplete="off">
                    <input type="text" id="search_karaoke" placeholder="Search Karaoke" autocomplete="off">
                </div>
            </div>

        </div>



        <!-- main right block 2nd subsection : right-queue -->
        <div class="right-queue">

            <!-- right queue header section -->
            <div id="queue_header">
                <span>
                    Queue
                    <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); margin-left:0.2vw; color:#004230;">playlist_play</i>
                </span>
            </div>


            <!-- right queue: clear the queue button -->
            <div class="clear_queue_div">
                <button class="button-right" id="clear" onclick="clear_Queue()">
                    Clear Queue
                    <i class="material-icons" style="font-size:clamp(1vw, 2vw, 3vw); margin-left:0.5vw;">delete_sweep</i>
                </button>
            </div>


            <!-- right queue: main section with queued items -->
            <div class="right-block-down" id="right-block-down"></div>


            <!-- right queue: scroll up and down buttons -->
            <div id="right-side-arrow">
                <!-- two buttons to scroll up and down the queue-->
                <button id="scroll_up" class="scroll_up_queue" onclick="scroll_up_queue()">
                    <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); position:absolute">arrow_circle_up</i>
                </button>

                <button id="scroll_down" class="scroll_down_queue" onclick="scroll_down_queue()">
                    <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); position:absolute">arrow_circle_down</i>
                </button>
            </div>

        </div>

    </div>




    <!-- top middle division - for playlist with thumbnails and search results-->
    <!-- switched with video-section later -->
    <div class="top-middle-block">

        <div id="div_img_video_loader">
            <h3>Click on the categories on the left side.<br>
                OR<br>
                Search songs from top-right corner.<br>
            </h3>
        </div>

        <div id="left-side-arrow">
            <!-- two buttons to scroll up and down the playlist-->
            <button id="scroll_up" class="scroll_up_content" onclick="scroll_up()">
                <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); position:absolute">arrow_circle_up</i>
            </button>

            <button id="scroll_down" class="scroll_down_content" onclick="scroll_down()">
                <i class="material-icons" style="font-size:clamp(1vw, 2.5vw, 3vw); position:absolute">arrow_circle_down</i>
            </button>
        </div>

    </div>




    <div id="footer">
        <span> Craig Williams Promotions. Call 1300-888-581 for Support.</span>

        <!-- yes/no modal style by jQueryUI and hidden input for youtube -->
        <div id="dialog-confirm"></div>
        <input type='hidden' id="search_query" name="search_query" placeholder="Search YouTube" autocomplete="off">
    </div>

</body>

</html>