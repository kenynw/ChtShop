@echo off
start iexplore.exe http://www.chahuitong.com/crontab/cj_index.php?act=date
ping -n 10 127.0.0.1>nul
taskkill /f /im iexplore.exe
exit