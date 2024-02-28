@echo off

set "img_folder=C:\Apache24\htdocs\music\Latest Hits\img"
set "music_folder=C:\Apache24\htdocs\music\Latest Hits"
set "dest_img_folder=C:\Apache24\htdocs\music\2000\img"
set "dest_music_folder=C:\Apache24\htdocs\music\2000"


for /f "usebackq" %%i in (`powershell -Command "(Get-Date).AddMonths(-6).ToString('yyyy-MM-dd')"`) do set six_months_ago=%%i
echo Based on your computer current date, 6 month ago would be %six_months_ago%.
echo Following songs will be moved from "Latest Hits" to "2000" categories:


set /a "count=0" 


for /F "tokens=*" %%a in ('powershell -Command "Get-ChildItem '%img_folder%' -File -Filter *.jpg | Select-Object -ExpandProperty FullName"') do (
    for /F "tokens=1 delims= " %%b in ('powershell -Command "(Get-ChildItem '%%a').CreationTime.ToString('yyyy-MM-dd')"') do (
	
        if "%%b" LSS "%six_months_ago%" (
	    set /a "count+=1"

	    echo.
          echo.
          echo %%~na was created more than six months ago.
          echo It was created on %%b which is older than %six_months_ago%

          echo Moving "%%~nxa" from "%img_folder%" to "%dest_img_folder%" 
          move /y "%%~fa" "%dest_img_folder%"

          echo Moving "%%~na.mp4" from "%music_folder%" to "%dest_music_folder%"
	    move /y "%music_folder%\%%~na.mp4" "%dest_music_folder%"
        )    
    )
)

if %count% EQU 0 ( 
    echo. 
    echo Oops!!! No songs over 6 months old found.
    echo.
)

echo.
echo In "Latest Hits", songs older than 6 months have been checked.
echo A total of "%count%" songs were moved.

echo.
echo Moving onto COPY phase in 3sec.
timeout /t 3 /nobreak