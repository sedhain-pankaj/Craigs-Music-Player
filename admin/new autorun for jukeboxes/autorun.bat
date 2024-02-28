@echo off

setlocal 
set "label=craig"

for /f "tokens=2 delims==" %%a in ('wmic volume where "label='%label%'" get driveletter /value') do set "drive=%%a"

if not defined drive (
    start firefox.exe -kiosk localhost
    exit /b 1
) else (
    echo.
    echo.
    echo Pendrive named %label% found. Checking drive letter for %label%.
    echo The drive letter for volume %label% is %drive%

    @REM Sets logfile name and uses powershell Tee-Object to run other 2 separate part of autorun.
    @REM The one that mentions both copy and move is permanent script.
    @REM powershell.exe -Command "$logFilename = '%drive%\Extras\Logs\Log ' + (Get-Date -Format 'yyyy-MM-dd hh-mm-ss tt') + '.log'; %drive%\Extras\autorun_move.bat | Tee-Object -FilePath $logFilename; %drive%\Extras\autorun_copy.bat | Tee-Object -Append -FilePath $logFilename"
    
    @REM This one is temporary. Remove the @REM from above and delete this after six months.
    powershell.exe -Command "$logFilename = '%drive%\Extras\Logs\Log ' + (Get-Date -Format 'yyyy-MM-dd hh-mm-ss tt') + '.log'; %drive%\Extras\autorun_copy.bat | Tee-Object -FilePath $logFilename;"


    echo.
    echo.
    echo Task completed. Remove the USB update drive and restart.
    pause
)
