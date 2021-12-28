<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/userService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $userService = new UserService();
        $userService -> getUser();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>