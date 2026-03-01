<# : batch section
@echo off
powershell.exe -ExecutionPolicy Bypass -Command "& {iex (get-content '%~f0' -raw)}"
exit /b
#>

$label = "craig"

# Find the USB drive by checking all drive letters
$drive = $null

foreach ($d in [System.IO.DriveInfo]::GetDrives()) {
    try {
        if ($d.IsReady -and $d.VolumeLabel -eq $label) {
            $drive = $d.Name.TrimEnd('\')
            break
        }
    } catch {
        continue
    }
}

if (-not $drive) {
    Write-Host "No update drive found."
    Write-Host "Starting Jukebox..."
    Start-Process "firefox.exe" -ArgumentList "-kiosk localhost"
    exit
}

Write-Host ""
Write-Host ""
Write-Host "Pendrive named $label found. Checking drive letter for $label."
Write-Host "The drive letter for volume $label is $drive"

# Create log filename
$logDir = "$drive\Extras\Logs"
if (-not (Test-Path $logDir)) {
    New-Item -ItemType Directory -Path $logDir -Force | Out-Null
}
$logFilename = "$logDir\Log $(Get-Date -Format 'yyyy-MM-dd hh-mm-ss tt').log"

# Run the update scripts and log output
# The one that mentions both copy and move is permanent script.
# Uncomment the next line and remove/comment the temporary one after six months.
# & "$drive\Extras\autorun_move.bat" | Tee-Object -FilePath $logFilename
# & "$drive\Extras\autorun_copy.bat" | Tee-Object -Append -FilePath $logFilename

# This one is temporary. Remove this and uncomment above after six months.
& "$drive\Extras\autorun_copy.bat" | Tee-Object -FilePath $logFilename

Write-Host ""
Write-Host ""
Write-Host "Task completed. Remove the USB update drive and restart."
pause
