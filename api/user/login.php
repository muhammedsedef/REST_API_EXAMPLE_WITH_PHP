<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/userService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $userService = new UserService();
        $userService -> login();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>