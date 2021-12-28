<?php
    class Product {
        private $id;
        private $name;
        private $description;
        private $image_url;
        private $created_date;
        private $is_active;

        public function getId() {
            return $this-> id;
        }
        public function setId($id) {
            $this -> id = $id;
        }

        public function getName() {
            return $this-> name;
        }
        public function setName($name) {
            $this -> name = $name;
        }

        public function getDescription() {
            return $this -> description;
        }
        public function setDescription($description) {
            $this -> description = $description;
        }

        public function getImageUrl() {
            return $this -> image_url;
        }
        public function setImageUrl ($image_url) {
            $this -> image_url = $image_url;
        }

        public function getCreatedDate() {
            return $this -> created_date;
        }
        public function setCreatedDate($created_date) {
            $this -> created_date = $created_date;
        }

        public function getIsActive() {
            return $this -> is_active;
        }
        public function setIsActive($is_active) {
            $this -> is_active = $is_active;
        }


    }
?>