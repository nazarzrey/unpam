@echo off
setlocal enabledelayedexpansion

del d:\renid.bat
for %%a in (*) do (
    set "filename=%%~na"
    set "ext=%%~xa"
    set "datetime=%%~ta"
    
    rem Extract date components (MM/DD/YYYY) and keep time as is (HH:MM AM/PM)
    for /f "tokens=1-3 delims=/ " %%b in ("%%~ta") do (
        set "month=%%b"
        set "day=%%c"
        set "year=%%d"
    )
    
    rem Keep the time part and replace : with .
    set "time=!datetime:~11,8!"
    set "time=!time::=.!"
    
    rem Construct the formatted date-time string as dd-MM-yyyy HH.MM AM/PM
    set "newdatetime=!day!-!month!-!year! !time!"
    
    rem Rename the file with the new date-time format
    echo ren "%%a" "!newdatetime!!ext!" >> d:\renid.bat
)

type  d:\renid.bat
endlocal
