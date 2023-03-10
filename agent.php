<?php
class Agent{
    protected $name;
    protected $number;
    function __construct($number){
        $this->number = $number;
    }
    public function getNumber(){
        return $this->number;
    }
    public function setNumber($number){
        $this->number = $number;
    }

    public function getName(){
        return $this->name;
    }
    public function setName($name){
        $this->name = $name;
    }
    public function readNameByNumber($pdo){
        $stmt = $pdo->prepare("select name form agent where agentNumber=?");
        $stmt->execute([$this->getNumber()]);
        $row = $stmt->fetch();
        if($row !=null){
            return $row['name'] ?? null;
        }else{
            return false;
        }
          }
          public function readIdByName($pdo){
            $stmt = $pdo->prepare ("select aid from agent where agentNumber =?");
            $stmt->execute([$this->getNumber()]);
            $row = $stmt->fetch();
            if($row != null){
                return$row['aid'] ?? null;

            }
            else{
                return false;
            }
          }
}
?>