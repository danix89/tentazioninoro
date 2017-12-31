Dim WinScriptHost
Dim objShell

Set objShell = WScript.CreateObject( "WScript.Shell" )

objShell.Run Chr(34) & "D:\xampp\apache_start.bat" & Chr(34), 0
objShell.Run Chr(34) & "D:\xampp\mysql_start.bat" & Chr(34), 0
objShell.Run Chr(34) & "D:\xampp\htdocs\tentazioninoro\windows_exe\open_browser.bat" & Chr(34), 0

Set objShell = Nothing
