@echo off
setlocal enabledelayedexpansion
md asli >nul
cls
echo.
echo.
for %%a in (asli\*.jpg) do (
	REM if not exist "asli\%%~nxa" (
		REM move "%%~nxa" asli\
	REM )
	if exist "asli\%%~nxa" (
		set naik=%1
		if "%1"=="" (
			magick "asli\%%~nxa" -modulate 110,100,100  "%%~na_up110%%~xa"
			echo magick "asli\%%~nxa" -modulate 110,100,100  "%%~na_up110%%~xa"
		) else (
			magick "asli\%%~nxa" -modulate %1,100,100  "%%~na_up!naik!%%~xa"
			echo magick "asli\%%~nxa" -modulate %1,100,100  "%%~na_up!naik!%%~xa"
		)
	)
)