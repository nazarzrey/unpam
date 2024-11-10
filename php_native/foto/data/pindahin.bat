@echo off
setlocal enabledelayedexpansion

for %%a in (*.jpg *.bmp *.png *.jpeg *.webp) do move "%%~fa" data\

endlocal