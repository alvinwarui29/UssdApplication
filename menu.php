<?php
include_once "util.php";
include_once "user.php";
include_once "transactions.php";
class Menu{
    protected $text;
    protected $sessionId ;

    function __construct(){}

    public function MainMenuRegistered($name){
        $response = "Welcome ".$name." to the app\n";
        $response .= "1. Send Money\n";
        $response .= "2. Withdraw money\n";
        $response .= "3. Check Balance\n";
        return $response;
    }
    public function MainMenuUnRegistered(){
        $response = "CON Is this your first time?\n";
        $response .= "1 Register\n";
        echo $response;
    }
    public function RegisterMenu($textArray,$phoneNumber,$pdo){
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
                $user = new User($phoneNumber);
                $user->setName($name);
                $user->setPin($pin);
                $user->setBalance(Util::$USER_BALANCE);
                $user->setPhone($phoneNumber);
                $user->register($pdo);
                echo "END SUCCESS";
            }
        }
    }
    public function SendMoneyMenu($textArray,$sender,$pdo,$sessionId){
        $level = count($textArray);
        $receiver = null;
        $nameOfReceiver = null;
        $response = "";
        if($level == 1){
            echo "CON Enter the number of the receiver\n";
        }else if($level ==2){
            echo "CON Enter amount";
        }else if($level ==3 ){
            echo "CON Enter your pin";
        }else if ($level == 4){
            $receiverMobile = $textArray[1];
            $receiverMobileWithCode = $this->addCountryCode($receiverMobile);
            $receiver = new User($receiverMobileWithCode);
            $nameOfReceiver = $receiver->readName($pdo);


            $response .= "Send". $textArray[2] ." to ". $nameOfReceiver."-".$receiverMobile . "\n";
            $response .= "1. Confirm\n";
            $response .= "2. Cancel\n";
            $response .= Util::$GO_BACK . " back\n";
            $response .= Util::$GO_TO_MAIN_MENU . " mainmenu\n";
            echo "CON". $response;
        }else if ($level == 5 && $textArray[4] ==1 ){
            // User is Confirming
            // send money
            $pin = $textArray[3];
            $amount = $textArray[2];
            $ttype ="send";
            $sender -> setPin($pin);
            $newSenderBalance = $sender->checkBalance($pdo) - $amount - Util::$TRANSACTION_FEE;
            $receiver = new User($this->addCountryCode($textArray[1]));
            $newRecieverBalance = $receiver->checkBalance($pdo) + $amount;

            if($sender->correctPin($pdo)==false){
                echo "END Wrong pin";
                //send smss
            }else{
                $txn = new Transaction($amount,$ttype);
                $result = $txn->sendMoney($pdo,$sender->readUserID($pdo),$receiver->readUserID($pdo),$newSenderBalance,$newRecieverBalance);

                if($result == true){
                    echo "END success will recieve a confirmation message shortly";

                }else{
                    echo "CON" .$result;
                }




            }




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
            echo " CON Enter agent number";

        }else if ($level ==2){
            echo " CON Enter Amount";

        }else if($level ==3){
            echo " CON Enter your pin";
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
    public function middleware($text){
        return $this->goBack($this->goMainMenu($text));
    }
    public function goBack($text){
        $explodedtext = explode("*",$text);
        while(array_search(Util::$GO_BACK,$explodedtext) != false){
            $firstIndex =array_search(Util::$GO_BACK,$explodedtext);
            array_splice($explodedtext,$firstIndex-1,2);
        
        }
        return join("*",$explodedtext);
    }
    public function goMainMenu($text){
        $explodedtext = explode("*",$text);
        while(array_search(Util::$GO_TO_MAIN_MENU,$explodedtext) != false){
            $firstIndex =array_search(Util::$GO_TO_MAIN_MENU,$explodedtext);
            $explodedtext = array_slice($explodedtext,$firstIndex+1);
        
        }
        return join("*",$explodedtext);
    }
    public function addCountryCode($phoneNumber){
        return Util::$COUNTRY_CODE . substr($phoneNumber,1);
    }

}
?>