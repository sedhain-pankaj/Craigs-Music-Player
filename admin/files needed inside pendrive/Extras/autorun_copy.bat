@echo off

setlocal 
set "label=craig"

for /f "tokens=2 delims==" %%a in ('wmic volume where "label='%label%'" get driveletter /value') do set "drive=%%a"

    echo.
    echo.
    echo Copying 2000's Songs
    @REM xcopy "%drive%\music\2000\*.mp4" "C:\Apache24\htdocs\music\2000\" /Y 
    powershell -Command "Copy-Item -Path '%drive%\music\2000\*.mp4' -Destination 'C:\Apache24\htdocs\music\2000\' -Force"
    echo 2000's Songs Completed


    echo.
    echo.
    echo Copying 2000's Images
    @REM xcopy "%drive%\music\2000\img\*.jpg" "C:\Apache24\htdocs\music\2000\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\2000\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\2000\img\' -Force"
    echo 2000's Images Completed


    echo.
    echo.
    echo Copying Christmas Songs
    @REM xcopy "%drive%\music\Christmas Song\*.mp4" "C:\Apache24\htdocs\music\Christmas Song\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Christmas Song\*.mp4' -Destination 'C:\Apache24\htdocs\music\Christmas Song\' -Force"
    echo Christmas Songs Completed


    echo.
    echo.
    echo Copying Christmas Images
    @REM xcopy "%drive%\music\Christmas Song\img\*.jpg" "C:\Apache24\htdocs\music\Christmas Song\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Christmas Song\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Christmas Song\img\' -Force"
    echo Christmas Images Completed


    echo.
    echo.
    echo Copying Country Songs
    @REM xcopy "%drive%\music\Country\*.mp4" "C:\Apache24\htdocs\music\Country\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Country\*.mp4' -Destination 'C:\Apache24\htdocs\music\Country\' -Force"
    echo Country Songs Completed


    echo.
    echo.
    echo Copying Country Images
    @REM xcopy "%drive%\music\Country\img\*.jpg" "C:\Apache24\htdocs\music\Country\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Country\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Country\img\' -Force"
    echo Country Images Completed


    echo.
    echo.
    echo Copying 80's Songs
    @REM xcopy "%drive%\music\Eighty\*.mp4" "C:\Apache24\htdocs\music\Eighty\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Eighty\*.mp4' -Destination 'C:\Apache24\htdocs\music\Eighty\' -Force"
    echo 80's Songs Completed


    echo.
    echo.
    echo Copying 80's Images
    @REM xcopy "%drive%\music\Eighty\img\*.jpg" "C:\Apache24\htdocs\music\Eighty\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Eighty\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Eighty\img\' -Force"
    echo 80's Images Completed


    echo.
    echo.
    echo Copying 50's and 60's Songs
    @REM xcopy "%drive%\music\Fifty Sixty\*.mp4" "C:\Apache24\htdocs\music\Fifty Sixty\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Fifty Sixty\*.mp4' -Destination 'C:\Apache24\htdocs\music\Fifty Sixty\' -Force"
    echo 50's and 60's Songs Completed


    echo.
    echo.
    echo Copying 50's and 60's Images
    @REM xcopy "%drive%\music\Fifty Sixty\img\*.jpg" "C:\Apache24\htdocs\music\Fifty Sixty\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Fifty Sixty\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Fifty Sixty\img\' -Force"
    echo 50's and 60's Images Completed


    echo.
    echo.
    echo Copying Karaoke Songs
    @REM xcopy "%drive%\music\Karaoke\*.mp4" "C:\Apache24\htdocs\music\Karaoke\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Karaoke\*.mp4' -Destination 'C:\Apache24\htdocs\music\Karaoke\' -Force"
    echo Karaoke Songs Completed


    echo.
    echo.
    echo Copying Karaoke Images
    @REM xcopy "%drive%\music\Karaoke\img\*.jpg" "C:\Apache24\htdocs\music\Karaoke\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Karaoke\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Karaoke\img\' -Force"
    echo Karaoke Images Completed


    echo.
    echo.
    echo Copying Latest Hits Songs
    @REM xcopy "%drive%\music\Latest Hits\*.mp4" "C:\Apache24\htdocs\music\Latest Hits\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Latest Hits\*.mp4' -Destination 'C:\Apache24\htdocs\music\Latest Hits\' -Force"
    echo Latest Hits Songs Completed


    echo.
    echo.
    echo Copying Latest Hits Images
    @REM xcopy "%drive%\music\Latest Hits\img\*.jpg" "C:\Apache24\htdocs\music\Latest Hits\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Latest Hits\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Latest Hits\img\' -Force"
    echo Latest Hits Images Completed


    echo.
    echo.
    echo Copying 90's Songs
    @REM xcopy "%drive%\music\Ninety\*.mp4" "C:\Apache24\htdocs\music\Ninety\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Ninety\*.mp4' -Destination 'C:\Apache24\htdocs\music\Ninety\' -Force"
    echo 90's Songs Completed


    echo.
    echo.
    echo Copying 90's Images
    @REM xcopy "%drive%\music\Ninety\img\*.jpg" "C:\Apache24\htdocs\music\Ninety\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Ninety\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Ninety\img\' -Force"
    echo 90's Images Completed


    echo.
    echo.
    echo Copying 70's Songs
    @REM xcopy "%drive%\music\Seventy\*.mp4" "C:\Apache24\htdocs\music\Seventy\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Seventy\*.mp4' -Destination 'C:\Apache24\htdocs\music\Seventy\' -Force"
    echo 70's Songs Completed


    echo.
    echo.
    echo Copying 70's Images
    @REM xcopy "%drive%\music\Seventy\img\*.jpg" "C:\Apache24\htdocs\music\Seventy\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Seventy\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Seventy\img\' -Force"
    echo 70's Images Completed


    echo.
    echo.
    echo Copying Special Occasion Songs
    @REM xcopy "%drive%\music\Special Occasion\*.mp4" "C:\Apache24\htdocs\music\Special Occasion\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Special Occasion\*.mp4' -Destination 'C:\Apache24\htdocs\music\Special Occasion\' -Force"
    echo Special Occasion Songs Completed


    echo.
    echo.
    echo Copying Special Occasion Images
    @REM xcopy "%drive%\music\Special Occasion\img\*.jpg" "C:\Apache24\htdocs\music\Special Occasion\img\" /Y
    powershell -Command "Copy-Item -Path '%drive%\music\Special Occasion\img\*.jpg' -Destination 'C:\Apache24\htdocs\music\Special Occasion\img\' -Force"
    echo Special Occasion Images Completed