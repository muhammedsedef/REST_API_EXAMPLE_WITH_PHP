<?php
    
    //include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/model/user.php");
    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/config/database.php");

    class UserRepository {
        private $db;

        function __construct() {
            $this -> db = new Database();
        }

        // create user 
        function createUser($user) {
        
            try{
                $response = array();

                // insert user into db
                $query = "INSERT INTO users SET first_name=:first_name, last_name=:last_name, email=:email, password=:password";

                // prepare query for execution
                $stmt = $this->db->getCon()->prepare($query);
                //$stmt = $con -> prepare($query);

                // bind the parameters
                $first_name = $user -> getFirstName();
                $last_name = $user -> getLastName();
                $email = $user -> getEmail();
                $password = $user -> getPassword();

                
                // checking email exist or not ! 
                $userQuery = "SELECT * FROM users WHERE email = ? LIMIT 0,1";
                $stmtForUser = $this->db->getCon()->prepare( $userQuery );
                $stmtForUser->bindParam(1, $email);
                $stmtForUser->execute();
                // store retrieved row to a variable
                $row = $stmtForUser->fetch(PDO::FETCH_ASSOC);

                if(!empty($row) ) {
                    $response['status'] = 409;
                    $response ['message'] ='This ' .$email .' email address has already our member';
                    return $response;
                }else{
                    // hashing password 
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $hashed_password);

                    // Execute the query
                    if($stmt->execute()){
                        $response['status'] = 200;
                        $response ['message'] ='User Successfully Created';
                        return $response;
                    }else{
                        $response['status'] = 500;
                        $response ['message'] ='An Unknown Error Occurred';
                        return $response;
                    }
                }
            }
            // show error
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
            
        } 

        // get user 
        function getUser($user) {

            try {
                $response = array();

                $id = $user->getId();
                $query;
                if($id) {
                    $user_response_array = $this -> findUserById($id);
                    unset($user_response_array['data']['password']);
                    return $user_response_array;
                }

                // return all user add later ==> skip limit (paginations)
                else {

                    $query = "SELECT * FROM users ORDER BY first_name DESC";
                    $stmt = $this -> db -> getCon() -> prepare($query);
                    $stmt -> execute();
                    
                    $data = array();
                    while($row = $stmt -> fetch(PDO::FETCH_ASSOC)) {
                        unset($row['password']);
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

        // update user informations
        function updateUser($user) {
            try {
                $id = $user -> getId();
                $first_name = $user -> getFirstName();
                $last_name = $user -> getLastName();
                $email = $user -> getEmail();
                
                $response = array();

                // check user exist or not ! 
                $user_response_array = $this -> findUserById($id);
                if($user_response_array['status'] == 404) {
                    return $user_response_array;
                }
                                    
                $query = "UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id";

                $stmt = $this -> db -> getCon() -> prepare($query);
                $stmt -> bindParam(':id', $id);
                $stmt -> bindParam(':first_name', $first_name);
                $stmt -> bindParam(':last_name', $last_name);
                $stmt -> bindParam(':email', $email);  
        
                if($stmt -> execute()) {
                    $response['status'] = 200;
                    $response['message'] = 'User Successfully Updated';
                    return $response;
                }
                else{
                    $response['status'] = 500;
                    $response['message'] = 'Error while user updating';
                    return $response;
                }
                
            }  
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }

        // delete user 
        function deleteUser($id) {
            try {
                $response = array();
                $is_active = 0;

                // check user exist or not ! 
                $user_response_array = $this -> findUserById($id);

                if($user_response_array['status'] == 200) { // means that user exist you can delete     
                    $query = "UPDATE users SET is_active = :is_active WHERE id = :id";

                    $stmt = $this -> db -> getCon() -> prepare($query);
                    $stmt -> bindParam(':id', $id);
                    $stmt -> bindParam(':is_active', $is_active);

                    if($stmt -> execute()) {
                        $response['status'] = 200;
                        $response['message'] = 'User Successfully deleted';
                        return $response;
                    }
                    else{
                        $response['status'] = 500;
                        $response['message'] = 'Error while user deleting';
                        return $response;
                    }
                }
                else { // user not exist return helper functions responss
                    return $user_response_array;
                }
                
            }
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }
        
        // login user 
        function login($user) {
            try {
                $response = array();

                // first check user is exist or not 
                $user_response_array = $this -> findUserByEmail($user -> getEmail());
                if($user_response_array['status'] == 404) {
                    return $user_response_array;
                }

                if(password_verify($user -> getPassword() ,$user_response_array['data']['password'])) { // password is correct
                    unset($user_response_array['data']['password']);
                    $response['status'] = 200;
                    $response['data'] = $user_response_array['data'];
                    $response['message'] = 'Successfully logged in';
                    return $response;
                }
                else { // password is incorrect
                    $response['status'] = 400;
                    $response['message'] = 'Password is incorrect';
                    return $response;
                }


            } 
            catch(PDOException $exception){
                die('ERROR: ' . $exception->getMessage());
            }
        }

        // find user by id (helper function for DONT REPEAT YOURSELF) 
        function findUserById($id) {    
            try {
                $response = array();

                $query = "SELECT * FROM users WHERE id=? LIMIT 0,1";
                    $stmt = $this->db->getCon() -> prepare($query);
                    $stmt -> bindParam(1, $id);
                    $stmt -> execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    
                    if(empty($row)) {
                        $response['status'] = 404;
                        $response['data'] = null;
                        $response['message'] = 'User not found';
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

        // find user by email (helper function for DONT REPEAT YOURSELF)
        function findUserByEmail($email) {
            try {
                $response = array();

                $query = "SELECT * FROM users WHERE email=? LIMIT 0,1";
                    $stmt = $this->db->getCon() -> prepare($query);
                    $stmt -> bindParam(1, $email);
                    $stmt -> execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    
                    if(empty($row)) {
                        $response['status'] = 404;
                        $response['data'] = null;
                        $response['message'] = 'No registered user found with the email you entered: ' .$email;
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