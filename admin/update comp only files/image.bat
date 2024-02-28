@echo off
setlocal
@CD /D "Extras"

echo Checking for Filenames. Apostrophe ' not allowed.
echo It will be removed if found.
@php "title.php"


echo.
echo.
echo Generating images. This is a time-consuming process.
echo Let it run until a task completed message is prompted.
echo.

@php "img.php"


echo.
echo.
echo Task completed. Close this terminal.
pause