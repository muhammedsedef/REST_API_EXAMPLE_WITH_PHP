<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/productService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $productService = new ProductService();
        $productService -> createProduct();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>