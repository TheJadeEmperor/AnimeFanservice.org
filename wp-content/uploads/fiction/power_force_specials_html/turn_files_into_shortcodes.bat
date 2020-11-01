@echo off

setlocal ENABLEDELAYEDEXPANSION

echo before loop

echo shortcodes > shortcodes.txt

FOR %%F in (*.html) do (
	
	set "fileName=%%F"
	
	echo !fileName!
	
	set "shortcode=[fanfic file=power_force_specials_html/!fileName!]"
	
	echo . >> shortcodes.txt
	echo !shortcode! >> shortcodes.txt
)

pause