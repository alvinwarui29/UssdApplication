<?php

class User{
    protected $name;
    protected $pin;
    protected $phone;
    protected $balance;

    function __construct($phone){
        $this->phone = $phone;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function getPhone(){
        return $this->phone;
    }
    public function setPhone($phone){
        $this->phone = $phone;
    }
    public function setBalance($balance){
        $this->balance= $balance;
    }
    public function getBalance(){
        return $this->balance;
    }
    public function setPin($pin){
        $this->pin= $pin;
    }
    public function getPin(){
        return $this->pin;
    }
    public function register ($pdo){
        try{
            $hashedPin = password_hash($this->getPin(),PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO ussdsms.user
        (name,pin,phone,balance) values (?,?,?,?)");
        $stmt -> execute([$this->getName(),$hashedPin
            ,$this->getPhone(),$this->getBalance()]);

        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    public function isUserRegistered ($pdo){
        $stmt = $pdo->prepare("SELECT * FROM ussdsms.user WHERE phone=?");
        $stmt->execute([$this->getPhone()]);
        if(count($stmt->fetchAll())>0){
            return true;
        }else{
            return false;
        }
    }
    public function readName ($pdo){
        $stmt = $pdo->prepare("SELECT * FROM ussdsms.user WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row["name"];
    }
    public function readUserID ($pdo){
        $stmt = $pdo->prepare("SELECT uid FROM ussdsms.user WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['uid'];
    }
    public function correctPin ($pdo){
        $stmt = $pdo->prepare("SELECT pin FROM ussdsms.user WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        if($row ==null){
            return false;
        }
        if(password_verify($this->getPin(),$row['pin'])){
            return true;
        }
        return false;
    }
    public function checkBalance ($pdo){
        $stmt = $pdo->prepare("SELECT uid FROM ussdsms.user WHERE phone = ?");
        $stmt->execute([$this->getPhone()]);
        $row = $stmt->fetch();
        return $row['balance'];

    }





}

?>