<?php


class databaseConnection {
    
    
    //private vars
    private $connection;
    private $database;
    
    
    //constructor
    public function __construct($database) {
        $this->connection = $this->makeConnection();
        $this->database = $database;
    }
    
    
    //makes connection with database
    private function makeConnection() {
        $conn = new mysqli("localhost","BM01","bm01123",$this->database);
        return $conn;
    }
    
    //return inserted id
    public function insert_id() {
        return $this->connection->insert_id;
    }
    
    //return error
    public function getError() {
        return $this->connection->error;
    }
    
    //close connection
    public function getConnection() {
        return $this->connection;
    }
    
    //close connection
    public function closeConnection() {
        $this->connection->close();
    }
    
    //do query
    public function queryDatabase($query) {
        
        //return false if there is no connection
        if (!($this->connection)) {
            return false;
        }
        
        $first_query = "USE ".$this->database.";";
        $this->connection->query($first_query);
    
        //query database
        $queryResult = $this->connection->query($query);
        
        //return query output
        return $queryResult;
    }
    
    
}


?>