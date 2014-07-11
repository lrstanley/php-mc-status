<?php
// Example usage:
//<iframe id="dyniframe"
//    seamless="seamless"
//    scrolling="no"
//    frameborder="0"
//    src="http://misc.liamstanley.io/mc.php?font=Pacifico&size=5&ip=vps.shad4wmc.tk&timeout=3&online=lime&offline=red&ontext=Server+online&offtext=SERVER IS OFFLINE!"
//    style="width:70;height:30;padding-top:21px;">
//    Loading
//</iframe>
 
$msg = '';
// IP (hostname/ip to connect the server to)
    if (empty($_GET["ip"])) {
        $msg = $msg.'
        <center>
            <h1>Possible GET variables</h1><hr>
            <font size="3">
               <br>GET Variables are "http://[url]?[get variable]&[another get variable]" etc
            </font>
        </center>
        <br><hr>
        <div style="padding-top:50px;">
            <b>ip</b> - A hostname or IP address to attempt to connect to (required)<br>
            <b>port</b> - The port that the Minecraft server is hosted on (Defaults to "25565")<br>
            <b>online</b> - The HTML "font" supportive color to use when the status returns True (Defaults to "none")<br>
            <b>offline</b> - Same as above, but is the color to use when the server return False (Defaults to "none")<br>
            <b>*ontext</b> - Text to use, instead of the simple "Online" (Defaults to "Online")<br>
            <b>*offtext</b> - Text to use, instead of the simple "Offline" (Defaults to "Offline")<br>
            <b>timeout</b> - Timeout in seconds to wait before auto-returning "Offline" (Defaults to "7" seconds)<br>
            <b>size</b> - The current text size multiplier (Defaults to "3")<br>
            (*) - Replace spaces in URL with "+" i.e for example to return "Server online", in the url use: Server+online
        </div>
               ';
        $go = False;
    } else {
        $ip = $_GET["ip"];
        $go = True;
    }
 
// PORT (defaults to the Minecraft server default (25565))
    if (empty($_GET["port"])) {
        $port = 25565;
    } else {
        $port = $_GET["port"];
    }
 
// ONLINE (color)
    if (empty($_GET["online"])) {
        $online = "";
    } else {
        $online = $_GET["online"];
    }
 
// ONLINE (text)
    if (empty($_GET["ontext"])) {
        $ontext = "Online";
    } else {
        $ontext = str_replace('+',' ',$_GET["ontext"]);
    }
 
// OFFLINE (color)
    if (empty($_GET["offline"])) {
        $offline = "";
    } else {
        $offline = $_GET["offline"];
    }
 
// OFFLINE (text)
    if (empty($_GET["offtext"])) {
        $offtext = "Offline";
    } else {
        $offtext = str_replace('+',' ',$_GET["offtext"]);
    }
 
// SIZE (font size)
    if (empty($_GET["size"])) {
        $size = 3;
    } else {
        $size = $_GET["size"];
    }
 
// TIMEOUT (time before it auto-fails and says offline (do this if it takes forever to load the content))
    if (empty($_GET["timeout"])) {
        $timeout = 7;
    } else {
        $timeout = $_GET["timeout"];
    }
 
// ONLY continue if acceptable request
     if ($go == True) {
        check($ip,$port,$online,$ontext,$offline,$offtext,$timeout,$size);
     }
    
// function that actually pings the port, to see if it's up. :P
    function check($ip,$port,$online,$ontext,$offline,$offtext,$timeout,$size) {
        $checkSock = @fsockopen($ip, $port, $errno, $errstr, $timeout);
        global $msg;
        // online!
        if ($checkSock !== FALSE)
        {
            $msg =  $msg.'<div><font color="'.$online.'" size="'.$size.'"><b>'.$ontext.'</b></font></div>';
        
        // offline!
        } else {
            $msg = $msg.'<div><font color="'.$offline.'" size="'.$size.'"><b>'.$offtext.'</b></font></div>';
        }
    }
// full output
    echo '
            <style type="text/css">
            body {background:none transparent;
            }
            </style>
            <title>Server Status Checker</title>
    ';
    echo $msg;
?>
