<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/userService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $userService = new UserService();
        $userService -> deleteUser();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>