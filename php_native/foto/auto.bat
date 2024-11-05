"L@echo off
color e0
setlocal EnableDelayedExpansion

    call :gambar
@REM for /l %%x in (1, 1, 5000) do (
@REM     echo.
@REM     echo.
@REM     echo hide in %%x
@REM     call :gambar
    
@REM     timeout /T 5 /NOBREAK
@REM )
rem exit

:gambar
rem attrib *.json -h
del *.json
echo [ > images.json

set isFirst=1

(for %%F in (img\*.jpg img\*.png img\*.webp img\*.jpeg) do (
    set "fileName=%%~nF%%~xF"
    
    rem Tentukan tipe sebagai L atau P secara default
    rem Untuk saat ini kita default saja sebagai "L" atau "P" sesuai preferensi
    
    set "konten=SomeContent"  rem Gantilah dengan logika atau variabel sesuai konten yang diinginkan
    set "tipe=L"  rem Ini default, Anda bisa mengatur deteksi manual atau statik
    
    if !isFirst! == 1 (
        echo {"nama": "!fileName!", "konten": "!konten!", "tipe": "!tipe!"} >> images.json
        set isFirst=0
    ) else (
        echo ,{"nama": "!fileName!", "konten": "!konten!", "tipe": "!tipe!"} >> images.json
    )
))

echo ] >> images.json
type images.json
rem attrib *.json +h
goto :EOF
