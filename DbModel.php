<?php

class DbModel{
    public $connection;
    public $query;
    public $sql;
    public function __construct(){
        $this->connection = mysqli_connect("localhost","root","","odccrud");
        return $this->connection;
    }
    public function select($table_name,$coulmn_name){
        $this->sql = "SELECT $coulmn_name FROM $table_name";
        
        return $this;
    }
    public function insert($table_name,$data){
        $culomns = "";
        $values = "";
        foreach($data as $key => $value){
            $culomns .= " `$key` ,";
            $values .= " '$value' ,";
        }
        $culomns =  rtrim($culomns,",");
        $values =  rtrim($values,",");
        $this->sql = "INSERT INTO $table_name ($culomns) VALUES ($values)";
        return $this;
    }
    public function update($table_name , $culomn , $operation , $value){
        $this->sql = " UPDATE $table_name SET $culomn  $operation  '$value'";
        
        return $this; 
    }
    public function delete($table_name){
        $this->sql = " DELETE FROM $table_name";
    }
    public function Andwhere($coulmn_name,$compair,$value){
        $this->sql .= " AND  $coulmn_name  $compair  $value";
        return $this;
    }
    public function Orwhere($coulmn_name,$compair,$value){
        $this->sql .= " OR  $coulmn_name  $compair  $value";
        return $this;
    }
    public function where($coulmn_name,$compair,$value){
        $this->sql .= " WHERE $coulmn_name  $compair  '$value' ";
        echo $this->sql;
        return $this;
    }
    public function all(){
        $this->query = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_all($this->query);
    }
    public function frist(){
        $this->query = mysqli_query($this->connection,$this->sql);
        return mysqli_fetch_assoc($this->query);
    }
    
    public function excute(){
        $this->query = mysqli_query($this->connection,$this->sql);
        if(mysqli_affected_rows($this->connection) > 0){
            return true;
        }else{
            return false;
        }
    }
}