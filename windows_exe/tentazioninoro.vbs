
'The advantage of this code is that it can be used in any application written in Vbscript and is easily editable and customizable!
'So just call the procedure SplashScreen foremost Main program! and voila (-_°)
'**************************************************************************************************
Call SplashScreen
Call MainProgram
'**************************************************************************************************
Sub SplashScreen()
Dim shell : Set shell = CreateObject("WScript.Shell")
Dim fso : Set fso = CreateObject("Scripting.FileSystemObject")
Dim tempFolder : Set tempFolder = fso.GetSpecialFolder(2)
Dim SplashName : SplashName = "Splash.hta"
Dim tempFile : Set tempFile = tempFolder.CreateTextFile(SplashName)
tempFile.Writeline "<html>"
tempFile.Writeline "<head>"
tempFile.Writeline "<title>Tentazioni in oro</title>"
tempFile.Writeline "<HTA:APPLICATION ID=""Splash Screen"""
tempFile.Writeline "APPLICATIONNAME=""Tentazioni in oro"""
tempFile.Writeline "BORDER=""none"""
tempFile.Writeline "CAPTION=""no"""
tempFile.Writeline "SHOWINTASKBAR=""no"""
tempFile.Writeline "SINGLEINSTANCE=""yes"""
tempFile.Writeline "SYSMENU=""no"""
tempFile.Writeline "SCROLL=""no"""
tempFile.Writeline "WINDOWSTATE=""normal"">"
tempFile.Writeline "</head>"
tempFile.Writeline"<SCRIPT LANGUAGE=""VBScript"">"
tempFile.Writeline "Sub CenterWindow(x,y)"        
tempFile.Writeline     "window.resizeTo x, y"      
tempFile.Writeline     "iLeft = window.screen.availWidth/2 - x/2"      
tempFile.Writeline     "itop = window.screen.availHeight/2 - y/2"    
tempFile.Writeline       "window.moveTo ileft, itop"      
tempFile.Writeline "End Sub"    
tempFile.Writeline "Sub Window_OnLoad"
tempFile.Writeline      "CenterWindow 520,520"
tempFile.Writeline      "iTimerID = window.setInterval(""ShowSplash"", 3000)"
tempFile.Writeline "End Sub"
tempFile.Writeline "Sub ShowSplash"
tempFile.Writeline     "Splash.Style.Display = ""None"""
tempFile.Writeline     "Window.Close()"
tempFile.Writeline     "End Sub"
tempFile.Writeline "</SCRIPT>"
tempFile.Writeline "<body bgcolor=""black"">"
tempFile.Writeline "<DIV id=""Splash"">"
tempFile.Writeline "<CENTER>"
tempFile.Writeline "<p>"
tempFile.Writeline "<img src=""C:\xampp\htdocs\tentazioninoro\windows_exe\images\logo.jpg""/>"
tempFile.Writeline "</p>"
tempFile.Writeline "</CENTER>"
tempFile.Writeline "</DIV>"
tempFile.Writeline "</body>"
tempFile.Writeline "</html>"
tempFile.Writeline "tempFile.Close"
shell.Run tempFolder & "\" & SplashName,1,True
End Sub
'**************************************************************************************************

Sub MainProgram
Dim objShell

Set objShell = WScript.CreateObject( "WScript.Shell" )

objShell.Run Chr(34) & "C:\xampp\apache_start.bat" & Chr(34), 0
objShell.Run Chr(34) & "C:\xampp\mysql_start.bat" & Chr(34), 0
Wscript.sleep 2000
objShell.Run Chr(34) & "C:\xampp\htdocs\tentazioninoro\windows_exe\open_browser.bat" & Chr(34), 0

Set objShell = Nothing

End Sub