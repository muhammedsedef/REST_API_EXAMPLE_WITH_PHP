<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/productService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        $productService = new ProductService();
        $productService -> getProduct();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>