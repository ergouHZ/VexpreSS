<?php
//CROS
header("Access-Control-Allow-Origin: https://8080-codeanywhere-templates-b-hbgcic273q.us1.codeanyapp.com/");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require 'database.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        //select the certain user
        $query = "SELECT * FROM user WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt->closeCursor();
        if ($user) {
            //verify the password, this is a php preset function for decryption
            if (password_verify($password, $user['password'])) {
                $_SESSION['username'] = $user['username'];
                $response['status'] = 200;  //success code is considered as 200
                $response['message'] = 'welcome';
            } else {
                //
                $response['status'] = 400;
                $response['message'] = 'wrong password';
            }
        } else {
            //The user does not exist
            $response['status'] = 400;
            $response['message'] = 'The user does not exist';
        }
    } catch (PDOException $e) {
        ob_clean(); // clean all the input beafore
        http_response_code(500); //
        $response['status'] = 500;
        $response['message'] = 'Database Error: ' . cleanErrorMessage($e->getMessage()); 
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}

function cleanErrorMessage($errorMessage)
{
    //clean the error message, or the format is wrong
    return trim(preg_replace('/\s+/', ' ', $errorMessage));
}

?>