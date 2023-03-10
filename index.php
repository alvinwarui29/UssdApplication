<?php
include_once "menu.php";
include_once "db.php";
include_once "user.php";
// Read the variables sent via POST from our API
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text        = $_POST["text"];

$user = new User($phoneNumber );
$db = new DBConnector();
$pdo = $db->connectToDB(); 
$menu = new menu();
$text = $menu->middleware($text);

if($text=="" && $user->isUserRegistered($pdo)){
    //text is empty and user is registered
    echo "CON " . $menu ->MainMenuRegistered($user->readName($pdo));
}else if($text=="" && !$user->isUserRegistered($pdo)){
    //text is empty and user is unregistered
    $menu -> MainMenuUnRegistered();
}else if($user->isUserRegistered($pdo)){
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
            echo "CON invalid Choice\n" . $menu->MainMenuRegistered($user->readName($pdo)) ;
    }

}else{
    //user is unregistered and text is not empty
    $textArray = explode("*",$text);
    switch($textArray[0]){
        case 1:
            $menu -> RegisterMenu($textArray,$phoneNumber,$pdo);
            break;
        default :
            echo "END invalid input ";
    }
}

?>