<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/model/product.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/repository/product/productRepository.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/core/error.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/core/validations.php");
    
    class ProductService {
        
        private $productRepository;

        function __construct() {
            $this -> productRepository = new productRepository();
        }

        function createProduct() {
            try {
                // create new Product object
                $product = new Product();

                // get inputs
                $json = file_get_contents('php://input');
                $input = json_decode($json, TRUE);
                
                // validations 
                $name = isset($input['name']) ? $input['name'] : null;
                $description = isset($input['description']) ? $input['description'] : null;
                $image_url = isset($input['image_url']) ? $input['image_url'] : null;

                // validate values -> add later some rules to check inputs 

                $product -> setName($name);
                $product -> setDescription($description);
                $product -> setImageUrl($image_url);

                $result = $this->productRepository -> createProduct($product);
                echo JSON(array(
                    'status' => $result['status'],
                    'data' => $result['data'],
                    'message' => $result['message']
                )); exit;

            }
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        function getProduct() {
            try {
                $id = isset($_GET["id"]) ? $_GET["id"] : null;
                
                // create new Product object
                $product= new Product();

                $product->setId($id); // null or id
                $result =$this->productRepository -> getProduct($product);
            
                echo JSON(array(
                    'status' => $result['status'],
                    'data' => $result['data'],
                    'message' => $result['message']
                )); exit;
                
                

            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        function updateProduct() {
            try {
                // to get patch request parameters 
                $queries = array();
                parse_str($_SERVER['QUERY_STRING'], $queries);

                $id = isset($queries["id"]) ? $queries["id"] : null;
                
                if(empty($id)){
                    apiError("Id missing");
                }

                // create new Product object
                $product = new Product();
                $product -> setId($id);
                
                // get inputs
                $json = file_get_contents('php://input');
                $input = json_decode($json, TRUE);
                
                // validations
                !empty($input['name']) ? $product -> setName($input['name']) : null;
                !empty($input['description']) ? $product -> setDescription($input['description']) : null;
                !empty($input['image_url']) ? $product -> setImageUrl($input['image_url']) : null;
                !empty($input['is_active']) ? $product -> setIsActive($input['is_active']) : null;

                
                // validate values -> todo : write validations for product input
                

                $result = $this->productRepository -> updateProduct($product);
                echo JSON(array(
                    'status' => $result['status'],
                    'message' => $result['message']
                )); exit;

            }
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        function deleteProduct() {
            try {
                // to get patch request parameters 
                $queries = array();
                parse_str($_SERVER['QUERY_STRING'], $queries);

                $id = isset($queries["id"]) ? $queries["id"] : null;
                
                if(empty($id)){
                    apiError("Id missing");
                }

                $result = $this->productRepository -> deleteProduct($id);
                echo JSON(array(
                    'status' => $result['status'],
                    'message' => $result['message']
                )); exit;
            }
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }

        }

        
    }
?>