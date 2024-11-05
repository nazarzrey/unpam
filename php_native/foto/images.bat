@echo off
setlocal enabledelayedexpansion
del *.json /ah
echo [ > images.json

set isFirst=1

(for %%F in (*.jpg *.png *.webp *.jpeg) do (
    if !isFirst! == 1 (
        echo "%%~nF%%~xF">> images.json
        set isFirst=0
    ) else (
        echo ,"%%~nF%%~xF">> images.json
    )
))

echo ] >> images.json

endlocal
attrib *.json -h
rem exit