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
    public function SendMoneyMenu($textArray){}
    public function WithdrawMoneyMenu($textArray){}
    public function CheckBalanceMenu($textArray){}

}
?>