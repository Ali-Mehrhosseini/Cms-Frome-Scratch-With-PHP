<?php

namespace DataBase;
use PDO;
Use PDOException;

class DataBase
{
private $connection;
private $option = array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION, 
PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC);
private $servername = 'localhost';
private $username = 'root';
private $dbname = 'blog';
private $password = '';

function __construct()
{


  try{
    $this->connection = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname,
    $this->username,$this->password,$this->option);
    }  


  catch(PDOException $e){
    echo "error" . $e->getMessage();
  }
}


public function select($sql,$values=NULL){

    try{
        if($values==NULL){
            return $this->connection->query($sql);
        }
        else{
            $stmt =$this->connection->prepare($sql);
            $stmt->execute($values);
            $result = $stmt;
            return $result;
        }
    }
    catch(PDOException $e){
        echo "error" . $e->getMessage();

    }
    
}


public function insert($tableName ,$fields, $values){
    try{
        $stmt=$this->connection->prepare("INSERT INTO ". $tableName . "(" . implode(',', $fields) ." , created_at ) VALUES( :" . implode(',
        :',$fields) . " , now() );");
        $stmt->execute(array_combine($fields,$values));
        return true;
    }
    catch(PDOException $e){
        echo "error" . $e->getMessage();

    }

}



 public function createTable($sql){
    try{
        $this->connection->exec($sql);
        return true;

    }

    catch(PDOException $e){
        echo "error" . $e->getMessage();
        return false;
    }


 }



}