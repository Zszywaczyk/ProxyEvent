<?php
@session_start();
interface iMy_op{
    public function __construct($host, $login, $password, $dbName);
    public function query($query);
    public function getRow();
    public function getAllRows();
    public function __destruct();
}

class My_op implements iMy_op{
    private $link;
    private $queryResult;
    public function __construct($host, $login, $password, $dbName){
        $this->link = mysqli_connect($host, $login, $password, $dbName);
        if (!$this->link) {
            throw new Exception ('Nie udalo sie polaczyc z baza danych: ' . $dbName);
        }
    }
    public function query($query)
    {
        $this->queryResult = mysqli_query($this->link, $query);

        return (bool)$this->queryResult;
    }
    public function getRow()
    {
        if (!$this->queryResult) {
            throw new Exception('Zapytanie nie zostalo wykonane');
        }

        return mysqli_fetch_assoc($this->queryResult);
    }
    public function getAllRows(){
        $results = array();

        while (($row = $this->getRow())) {
            $results[] = $row;
        }

        return $results;
    }
    public function __destruct(){

    }
}