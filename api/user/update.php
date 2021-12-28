<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/userService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
        $userService = new UserService();
        $userService -> updateUser();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
   
?>