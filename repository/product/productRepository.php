<?php
    
    //include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/model/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/config/database.php");

    class ProductRepository {
        private $db;

        function __construct() {
            $this -> db = new Database();
        }

        // create product 
        function createProduct($product) {
        
            try{
                $response = array();

                // insert user into db
                $query = "INSERT INTO products SET name=:name, description=:description, image_url=:image_url";

                // prepare query for execution
                $stmt = $this->db->getCon()->prepare($query);
                //$stmt = $con -> prepare($query);

                // bind the parameters
                $name = $product -> getName();
                $description = $product -> getDescription();
                $image_url = $product -> getImageUrl();
                
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image_url', $image_url);

                // Execute the query
                if($stmt->execute()){
                    $response['status'] = 200;
                    $response['data'] = $this -> db -> getCon() -> lastInsertId(); // last inserted record
                    $response['message'] = 'User Successfully Created';
                    return $response;
                }else{
                    $response['status'] = 500;
                    $response['data'] = null;
                    $response ['message'] ='An Unknown Error Occurred';
                    return $response;
                }
            }
            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
            
        } 

        // get product 
        function getProduct($product) {

            try {
                $response = array();

                $id = $product->getId();
                $query;
                if($id) {
                    $product_response_array = $this -> findProductById($id);
                    return $product_response_array;
                }

                // return all product add later ==> skip limit (paginations)
                else {
                    $query = "SELECT * FROM products ORDER BY name DESC";
                    $stmt = $this -> db -> getCon() -> prepare($query);
                    $stmt -> execute();
                    $data = array();
                
                    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        array_push($data, $row);
                    }
                   
                    $response['status'] = 200;
                    $response['data'] = $data;
                    $response['message'] = 'success';
                    return $response;
                }
            
            } 
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }

        // update product informations
        function updateProduct($product) {
            try {
                $id = $product -> getId();
                $name = $product -> getName();
                $description = $product -> getDescription();
                $image_url = $product -> getImageUrl();
                $is_active = $product -> getIsActive();
                
                $response = array();

                // check user exist or not ! 
                $product_response_array = $this -> findProductById($id);
                if($product_response_array['status'] == 404) {
                    return $product_response_array;
                }
                                    
                $query = "UPDATE products SET name = :name, description = :description, image_url = :image_url, is_active = :is_active WHERE id = :id";

                $stmt = $this -> db -> getCon() -> prepare($query);
                $stmt -> bindParam(':id', $id);
                $stmt -> bindParam(':name', $name);
                $stmt -> bindParam(':description', $description);
                $stmt -> bindParam(':image_url', $image_url);  
                $stmt -> bindParam(':is_active', $is_active);  
        
                if($stmt -> execute()) {
                    $response['status'] = 200;
                    $response['message'] = 'Product Successfully Updated';
                    return $response;
                }
                else{
                    $response['status'] = 500;
                    $response['message'] = 'Error while product updating';
                    return $response;
                }
                
            }  
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }

        // delete product 
        function deleteProduct($id) {
            try {
                $response = array();
                $is_active = 0;

                // check product exist or not ! 
                $product_response_array = $this -> findProductById($id);

                if($product_response_array['status'] == 200) { // means that product exist you can delete     
                    $query = "UPDATE products SET is_active = :is_active WHERE id = :id";

                    $stmt = $this -> db -> getCon() -> prepare($query);
                    $stmt -> bindParam(':id', $id);
                    $stmt -> bindParam(':is_active', $is_active);

                    if($stmt -> execute()) {
                        $response['status'] = 200;
                        $response['message'] = 'Product Successfully deleted';
                        return $response;
                    }
                    else{
                        $response['status'] = 500;
                        $response['message'] = 'Error while product deleting';
                        return $response;
                    }
                }
                else { // product not exist return helper functions responss
                    return $product_response_array;
                }
                
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        

        // find product by id (helper function for DONT REPEAT YOURSELF) 
        function findProductById($id) {    
            try {
                $response = array();

                $query = "SELECT * FROM products WHERE id=? LIMIT 0,1";
                    $stmt = $this->db->getCon() -> prepare($query);
                    $stmt -> bindParam(1, $id);
                    $stmt -> execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    
                    if(empty($row)) {
                        $response['status'] = 404;
                        $response['data'] = null;
                        $response['message'] = 'Product not found';
                        return $response;
                    }
                    else{
                        $response['status'] = 200;
                        $response['data'] = $row;
                        $response['message'] = 'Success';
                        return $response;
                    }
            } 
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }

    }

    
?>