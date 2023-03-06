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
}else if(!$isRegistered){
    //text is not empty and user is regisered
    $textArray = explode("*",$text);
    switch($textArray[0]){
        case 1 :
            $menu->SendMoneyMenu($textArray);
            break;
        case 2 :
            $menu->WithdrawMoneyMenu($textArray);
            break;
        case 3 :
            $menu->CheckBalanceMenu($textArray);
            break;
        default:
            echo "END Invalid choice try again";
    }

}else{
    //user is unregistered and text is not empty
    $textArray = explode("*",$text);
    switch($textArray[0]){
        case 1:
            $menu -> RegisterMenu($textArray);
            break;
        default :
            echo "END invalid input ";
    }
}

?>