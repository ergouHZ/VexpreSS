<?php
    $dsn = 'mysql:host=localhost;dbname=php_project_123106027';
    $username = 'mgs_tester';
    $password = '5tTvlqWm_n';

    try {
        $db = new PDO($dsn, $username, $password);

    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../../errors/database_error.php');
        exit();
        
    }
?>