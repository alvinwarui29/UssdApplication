<?php
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
    public function RegisterMenu(){}
    public function SendMoneyMenu(){}
    public function WithdrawMoneyMenu(){}
    public function CheckBalanceMenu(){}

}
?>