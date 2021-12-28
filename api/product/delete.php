<?php

    include_once($_SERVER["DOCUMENT_ROOT"] . "/test_api/business/productService.php");
    
    if($_SERVER['REQUEST_METHOD'] === 'DELETE'){
        $productService = new ProductService();
        $productService -> deleteProduct();
    }
    else{
        apiError("Wrong Path. Check API Endpoint!");
    }
    

    
   
?>