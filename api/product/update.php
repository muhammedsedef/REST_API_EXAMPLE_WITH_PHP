<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/productService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'PATCH'){
        $productService = new ProductService();
        $productService -> updateProduct();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>