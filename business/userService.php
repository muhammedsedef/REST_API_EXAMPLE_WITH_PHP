<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/model/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/repository/user/userRepository.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/core/error.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/core/validations.php");
    
    class UserService {
        
        private $userRepository;

        function __construct() {
            $this -> userRepository = new UserRepository();
        }

        function createUser() {
            try {
                // create new User object
                $user = new User();

                // get inputs
                $json = file_get_contents('php://input');
                $input = json_decode($json, TRUE);
                
                // validations 
                $first_name = isset($input['first_name']) ? $input['first_name'] : null;
                $last_name = isset($input['last_name']) ? $input['last_name'] : null;
                $email = isset($input['email']) ? $input['email'] : null;
                $password = isset($input['password']) ? $input['password'] : null;

                // validate values
                $validationResult = validateParams($first_name, $last_name, $email, $password);
                if(!empty($validationResult)) {
                    validationError($validationResult);
                }

                $user -> setFirstName($first_name);
                $user -> setLastName($last_name);
                $user -> setEmail($email);
                $user -> setPassword($password);


                $result = $this->userRepository -> createUser($user);
                echo JSON(array(
                    'status' => $result['status'],
                    'message' => $result['message']
                )); exit;

            }
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        function getUser() {
            try {
                $id = isset($_GET["id"]) ? $_GET["id"] : null;
                // create new User object
                $user = new User();

                $user->setId($id); // null or id
                $result =$this->userRepository -> getUser($user);
            
                echo JSON(array(
                    'status' => $result['status'],
                    'data' => $result['data'],
                    'message' => $result['message']
                )); exit;
                
                

            } catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        function updateUser() {
            try {
                // to get patch request parameters 
                $queries = array();
                parse_str($_SERVER['QUERY_STRING'], $queries);

                $id = isset($queries["id"]) ? $queries["id"] : null;
                
                if(empty($id)){
                    apiError("Id missing");
                }

                // create new User object
                $user = new User();
                $user -> setId($id);
                // get inputs
                $json = file_get_contents('php://input');
                $input = json_decode($json, TRUE);
                
                // validations
                !empty($input['first_name']) ? $user -> setFirstName($input['first_name']) : null;
                !empty($input['last_name']) ? $user -> setLastName($input['last_name']) : null;
                !empty($input['email']) ? $user -> setEmail($input['email']) : null;

                
                // validate values
                $validationResult = validateParamsForUpdate($user);
                if(!empty($validationResult)) {
                    validationError($validationResult);
                }

                $result = $this->userRepository -> updateUser($user);
                echo JSON(array(
                    'status' => $result['status'],
                    'message' => $result['message']
                )); exit;

            }
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }
        }

        function deleteUser() {
            try {
                // to get patch request parameters 
                $queries = array();
                parse_str($_SERVER['QUERY_STRING'], $queries);

                $id = isset($queries["id"]) ? $queries["id"] : null;
                
                if(empty($id)){
                    apiError("Id missing");
                }

                $result = $this->userRepository -> deleteUser($id);
                echo JSON(array(
                    'status' => $result['status'],
                    'message' => $result['message']
                )); exit;
            }
            catch (PDOException $exception) {
                die('ERROR: ' . $exception->getMessage());
            }

        }

        function login() {
            try {
                // get inputs
                $json = file_get_contents('php://input');
                $input = json_decode($json, TRUE);

                // create new User object
                $user = new User();

                // get request body
                $email = isset($input['email']) ? $input['email'] : null;
                $password = isset($input['password']) ? $input['password'] : null;

                $user -> setEmail($email);
                $user -> setPassword($password);

                $result = $this->userRepository -> login($user);
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
    }
?>