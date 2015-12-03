<?php

include('dbcrendentials');


class MydbClass{

    private $dbuser = DATAUSER;
    private $dbname = DATANAME;
    private $dbpass = DATAPASS;

    private $pdo;
    private $stm;
    private $error;

      function __construct(){
        try{

            $dbinfo = "mysql:host=localhost;dbname=" . $this->dbname;
            $this->pdo = new PDO ($dbinfo, $this->dbuser, $this->dbpass);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
        }
        catch(PDOException $e) {
            
           $this->error = $e->getMessage();
        }

        return $this;

    }//end of connect


    public function find($query){
        $this->stm = $this->pdo->prepare($query);
    }

    public function execute($values){
        try{
           return $this->stm->execute($values);
        }
        catch(PDOException $e) {
          print_r($this->stm->errorInfo());

        }
    }

    public function singleRow($value){
        return $this->stm->fetchColumn();
    }

    public function allRows(){
         return $this->stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function arrayRows(){
        return $this->stm->fetchAll(PDO::FETCH_COLUMN);
    }

    public function rowCount(){
        return $this->stm->rowCount();
    }

    public function lastID(){
        return $this->pdo->lastInsertId();
    }
    
    public function disconnect(){
        $this->pdo = NULL;
    }

    
}//end of class


?>
