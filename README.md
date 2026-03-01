# Craigs-Music-Player

A simple web-based jukebox video player written in PHP, HTML, CSS, JS. It uses libraries like jQuery, jQueryUI, mediaElementJS, Google's material icons, Keyboard. It requires PHP to run and FFMpeg to generate thumbnails via the admin folder. PHP-composer is pre-bundled in the admin folder.

## Features

- The admin folder contains batch files that can be used to update the jukebox (Windows only). It is split into 3 parts:
  - Files needed by the pendrive used for update.
  - The autorun setup needed in the jukebox.
  - The files for the computer used to generate thumbnails and prepare the USB-stick needed for update.

## Usage

- Run `php -S localhost:8000` in the terminal from the folder where `index.php` is located.
- Open your browser and navigate to `localhost:8000` to view the application.
- Instead of using the dev-mode web server from inbuilt PHP, Apache may also be used to serve as a web server (directly or via xampp/mamp). In that case, place the root of files inside the `htdocs` folder of Apache.
- Open your browser and see if localhost shows the files inside `/music/`. Thumbnails will be empty unless generated separately by `image.bat` located in `/admin/update`.
- Remove apostrophes and other special characters from filenames to avoid any PHP parsing error or JS-array error. Checks are in place to null special characters but it's better to avoid them in the first place.
- `autorun_move.bat` from `/admin/pendrive` moves songs older than 6 months from latest hits to 2000 categories.

## Quirks

- In youtube.js, you will need the $YT_API_Key. It's free but needs to be created.
- Batch script could use GUI and sound feedback on current task.
- Zooming in too much may cause CSS to overlap.
- Volume slider requires multi-touch display. Use + and - button on single touch display.
- Splitter used with single port HDMI. 1st goes to jukebox and 2nd for TV.
- Large song's volume especially for 2000 and Karaoke may slow down load time.
- All videos are not 16/9 aspect ratio. May result in black bar.
- Search function requires high read capacity SSD.

## Demo

A visual representation is available in `/music/demo.png`:

![](music/demo.png)
