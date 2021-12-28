<?php
    class User {
        private $id;
        private $first_name;
        private $last_name;
        private $email;
        private $password;
        private $is_active;

        public function getId() {
            return $this->id;
        }
        public function setId($id) {
            $this -> id = $id;
        }

        public function getFirstName() {
            return $this->first_name;
        }
        public function setFirstName($first_name) {
            $this -> first_name = $first_name;
        }

        public function getLastName() {
            return $this -> last_name;
        }
        public function setLastName($last_name) {
            $this -> last_name = $last_name;
        }

        public function getEmail() {
            return $this -> email;
        }
        public function setEmail ($email) {
            $this -> email = $email;
        }

        public function getPassword() {
            return $this -> password;
        }
        public function setPassword($password) {
            $this -> password = $password;
        }

        public function getIsActive() {
            return $this -> is_active;
        }
        public function setIsActive($is_active) {
            $this -> is_active = $is_active;
        }


    }
?>