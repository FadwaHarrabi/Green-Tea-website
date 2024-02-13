<?php

// Database connection parameters
$dsn = 'mysql:host=localhost;dbname=shop_db';
$username = 'root';
$password = '';

try {
    // Create a PDO instance
    $conn = new PDO($dsn, $username, $password);

    function unique_id(){
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLength = strlen($chars);
        $randomString = '';
        for ($i=0; $i < 20; $i++) {
            $randomString.=$chars[mt_rand(0, $charsLength - 1)];
        } 
        return $randomString;
    }

    // Set PDO error mode to exceptions for better error handling
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>