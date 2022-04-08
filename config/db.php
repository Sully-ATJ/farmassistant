<?php

    include 'config.php';
    Class Db{
        private $host;
        private $user;
        private $password;
        private $database;
        protected $conn;

        //Connection function
        public function connect(){

            $this->host = DBHOST;
            $this->user = DBUSERNAME;
            $this->password = DBPWD;
            $this->database = DBNAME;

            try {
                $dsn = "mysql:host=" .$this->host.";dbname=". $this->database;
                $this->$conn = new PDO($dsn, $this->user, $this->password);
                $this->$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                return $this->$conn;
            } catch (PDOException $e) {
                echo "Connection failed: ".$e->getMessage();
            } 
        }

        //Ending connection
        public function closeConnection(){

            $this->$conn = null;
        }
    }
?>