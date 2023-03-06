<?php
include_once "menu.php";
// Read the variables sent via POST from our API
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

$isRegistered = true;
$menu = new menu($text,$sessionId );

if($text=="" && !$isRegistered){
    //text is empty and user is registered
    $menu ->MainMenuRegistered();
}else if($text=="" && $isRegistered){
    //text is empty and user is unregistered
    $menu -> MainMenuUnRegistered();
}else if($isRegistered){
    //text is not empty and user is regisered
}else{
    //user is unregistered and text is not empty
}

?>