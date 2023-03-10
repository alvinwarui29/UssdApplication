<?php
class Transaction{
    protected $amount;
    protected $ttype;

    function __construct($amount,$ttype){
        $this->amount = $amount;
        $this->ttype = $ttype;
    }

    public function getAmount(){
        return $this->amount;
    }
    public function getTType(){
        return $this->ttype;
    }
    public function sendMoney($pdo,$uid,$ruid,$newSenderBalance,$newReceiverBalance){
        $pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,false);
        try{
            $pdo->beginTransaction();
            $stmtT =$pdo->prepare('insert into transaction
            (amount,uid,ruid,ttype) values (?,?,?,?)
            ');
            $stmtU = $pdo->prepare('update user balance=? where uid=?');
            $stmtT->execute([$this->getAmount(),
            $uid,$ruid,$this->getTType()]);
            $stmtU->execute($newSenderBalance,$uid);
            $stmtU->execute($newReceiverBalance,$ruid);

            $pdo->commit();
            return true;
        }
        catch(Exception $e){
            $pdo->rollback();
            return "An error occured";
        }
    }
    public function withdrawCash($pdo,$uid,$aid,$newbalance){}
}

?>
