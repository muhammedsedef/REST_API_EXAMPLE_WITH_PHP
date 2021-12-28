<?php
   
    class Database {
        // used to connect to the database
        private $host = "localhost";
        private $db_name = "engr372";
        private $username = "root";
        private $password = "";
        private $con;

        function __construct() {
            try{
                $this -> con = new PDO("mysql:host={$this->host};dbname={$this->db_name}", $this->username, $this->password);
            }
            // show error
            catch(PDOException $exception){
                echo "Connection error: " . $exception->getMessage();
            }
        }

        public function getCon() {
            return $this -> con;
        }
    }
    
?>
