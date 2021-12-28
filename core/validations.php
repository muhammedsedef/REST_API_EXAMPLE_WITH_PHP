<?php
require_once('error.php');

function validateParams($first_name, $last_name, $email, $password) {
    $errors = [];
    $first_name_length = strlen($first_name) <= 0 ? $errors['first_name'] = "First Name cannot empty" : strlen($first_name);
    $last_name_length = strlen($last_name) <= 0 ? $errors['last_name'] = "Last Name cannot empty" : strlen($last_name);
    $email_length = strlen($email) <= 0 ? $errors['email'] = "Email cannot empty" : strlen($email);
    $password_length = strlen($password) <= 0 ? $errors['password'] = "Password cannot empty" : strlen($password);

    if(count($errors)) {
        return $errors;
    }

    // first_name validation 
    if($first_name_length < 2 || $first_name_length > 155) {
        $errors['first_name'] = "First Name length must be grater than 2 and lower than 155 charecters";
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
        $errors['first_name']  = "Only letters and white space allowed";
    }

    // last_name validation
    if($last_name_length < 2 || $last_name_length > 155) {
        $errors['last_name'] = "Last Name length must be grater than 2 and lower than 155 charecters";
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
        $errors['last_name']  = "Only letters and white space allowed";
    }

    // email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // password validation
    if($password_length < 6 || $password_length > 32) {
        $errors['password'] = "Password length must be grater than 6 and lower than 32 charecters";
    }
    return $errors;
}

function validateParamsForLogin($email, $password) {
    $errors = [];
    $email_length = strlen($email) <= 0 ? $errors['email'] = "Email cannot empty" : strlen($email);
    $password_length = strlen($password) <= 0 ? $errors['password'] = "Password cannot empty" : strlen($password);

    if(count($errors)) {
        return $errors;
    }

    // email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    // password validation
    if($password_length < 6 || $password_length > 32) {
        $errors['password'] = "Password length must be grater than 6 and lower than 32 charecters";
    }
    return $errors;  
}
function validateParamsForUpdate($user) {
    $first_name = $user -> getFirstName();
    $last_name = $user -> getLastName();
    $email = $user -> getEmail();

    $errors = [];

    // first_name validation 
    if(strlen($first_name) < 2 || strlen($first_name) > 155) {
        $errors['first_name'] = "First Name length must be grater than 2 and lower than 155 charecters";
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $first_name)) {
        $errors['first_name']  = "Only letters and white space allowed";
    }

    // last_name validation
    if(strlen($last_name) < 2 || strlen($last_name) > 155) {
        $errors['last_name'] = "Last Name length must be grater than 2 and lower than 155 charecters";
    }
    if (!preg_match("/^[a-zA-Z-' ]*$/", $last_name)) {
        $errors['last_name']  = "Only letters and white space allowed";
    }

    // email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    return $errors; 
}
function validationError($validateError = array()) {
    echo JSON(array(
        'status' => 500,
        'message' => 'Form Data Validation Error, Check Your Inputs!',
        'errors' => $validateError
    )); exit;
}
?>