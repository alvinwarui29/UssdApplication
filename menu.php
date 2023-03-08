<?php
include_once "util.php";
class Menu{
    protected $text;
    protected $sessionId ;

    function __construct($text,$sessionId )
    {
        $this->text = $text;
        $this->sessionId = $sessionId;
    }

    public function MainMenuRegistered(){
        $response = "CON Welcome to the app\n";
        $response .= "1. Send Money\n";
        $response .= "2. Withdraw money\n";
        $response .= "3. Check Balance\n";
        echo $response;
    }
    public function MainMenuUnRegistered(){
        $response = "CON Is this your first time?\n";
        $response .= "1 Register\n";
        echo $response;
    }
    public function RegisterMenu($textArray){
        $level = count($textArray);

        if($level == 1){
            echo "CON Enter your full name : ";
        }else if($level ==2){
            echo "CON Enter your pin";
        }else if($level == 3){
            echo "CON Confirm your pin";
        }else if($level ==4){
            $name = $textArray[1];
            $pin = $textArray[2];
            $conPin = $textArray[3];

            if($pin != $conPin){
                echo "END Pin does not match";
            }else{
                //register the user;
                echo "END SUCCESS";
            }
        }
    }
    public function SendMoneyMenu($textArray){
        $level = count($textArray);
        if($level == 1){
            echo "CON Enter the number of the receiver\n";
        }else if($level ==2){
            echo "CON Enter amount";
        }else if($level ==3 ){
            echo "CON Enter your pin";
        }else if ($level == 4){
            $response = "CON Send". $textArray[2] ." to ". $textArray[1] . "\n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel\n";
            $response .= Util::$GO_BACK . "back\n";
            $response .= Util::$GO_TO_MAIN_MENU . "mainmenu\n";
            echo $response;
        }else if ($level == 5 && $textArray[4] ==1 ){
            // User is Confirming
            // send money
            echo "END Money sent!";
        }else if ($level == 5 && $textArray[4] ==2 ){
            // User has cancelled
            echo "END Confirmed Cancellation";
        }else if ($level == 5 && $textArray[4] ==Util::$GO_BACK ){
            // User is going back
            echo "END Going back...";
        }
        else if ($level == 5 && $textArray[4] ==Util::$GO_TO_MAIN_MENU ){
            // User is going to main menu
            echo "END Going to Main Menu";
        }else{
            echo" END Invalid Choice!";
        }
    }
    public function WithdrawMoneyMenu($textArray){
        $level = count($textArray);
        if ($level ==1){
            echo "CON Enter agent number";

        }else if ($level ==2){
            echo "CON Enter Amount";

        }else if($level ==3){
            echo "CON Enter your pin";
        }else if($level ==4){
            echo "CON Withdraw ". $textArray[2] . " From agent " . $textArray[1] . "\n 1. Confirm\n 2. Cancel\n";
        }else if ($level ==5 && $textArray[4 ==1]){
            //confirm
            echo "END Thanks for withdrawing";
        }
        else if ($level ==5 && $textArray[4 ==2]){
            //cancelled
            echo "END Cancelled";
        }else{
            echo "END Invalid Option";
        }
    }
    public function CheckBalanceMenu($textArray){
        $level = count($textArray);
        if($level ==1){
            echo "CON Enter pin";
        }else if ($level ==2){
            echo "CON Checking balance";
        }else{
            echo "END Invalid pin";
        }
    }

}
?>