<?php

class db{
    public $con;
    public $excution_query = "";

    public function __construct($server, $user, $pass, $database)
    {
        
        $this->con = mysqli_connect($server,$user, $pass, $database);
    }

    public function select($tname, $Return_dataORtext_excutionqueryauto="")
    {
        if ($Return_dataORtext_excutionqueryauto == "text") {
            $q = "SELECT * FROM $tname";
            return $q;
        }
        elseif($Return_dataORtext_excutionqueryauto == "data") {
            $q = mysqli_query($this->con, "SELECT * FROM $tname");
            return mysqli_fetch_all($q, MYSQLI_ASSOC);
        }else{
            $q = ", SELECT * FROM $tname";
        $this->excution_query = $q;

        }
    }

    public function Where($condition)
    {
        $this->excution_query .= " WHERE $condition ";

    }
    public function ANDwhere($condition)
    {
        $this->excution_query .= " AND $condition ";

    }
    public function ORwhere($condition)
    {
        $this->excution_query .= " OR $condition ";
    }

    public function update($data, $table, $condition)
    {
        $query = "UPDATE $table SET ";

        foreach ($data as $cols => $value) {
            $query .= "$cols = $value , ";
        }
        substr($query, 0, -1);
        $query .= "WHERE " . $condition;
        $this->excution_query = $query;

    }
    public function insert($data, $condition)
    {
        $query = "INSERT INTO  ";
        $col = "( ";
        $val = " VALUES ( ";
        foreach ($data as $cols => $value) {
            $col .= $cols . ", ";
            $val .= $value . ", ";
        }

        substr($cols, 0, -2);
        substr($val, 0, -2);
        $col .= $cols . ") ";
        $val .= $value . ") ";
        $query .= "WHERE " . $condition;

        $this->excution_query = $query;

    }

    public function delete($tablename, $condition)
    {
        $query = "DELETE FROM $tablename WHERE $condition";

        $this->excution_query = $query;
    }
    public function execute(){
        $query = mysqli_query($this->con, $this->excution_query);
        if (mysqli_affected_rows($this->con) != 1) {
            echo $this->excution_query . " !! NOT WORKING !!";
        }else{
            return mysqli_fetch_all($query,MYSQLI_ASSOC);
        }   
    }
}

?>