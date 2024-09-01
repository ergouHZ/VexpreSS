<?php
session_start(); //this is needed to read the username

//if post to this api, then clear the username session, if GET this one, then return the username
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $response = array(); //the response body
    
    try {
        //get the username in the user session
        $username = $_SESSION['username'];
        if (!isset($username)){
            $response['status'] = 201;
            $response['message'] = 'You have to Login first';
        }else{
            $response['status'] = 200;
            $response['message'] = 'Get the username successfully';
            $response['username'] = $username;
        }

    } catch (Exception $e) {
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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();
    unset($_SESSION["username"]);

    $response['status'] = 200;
    $response['message'] = 'User has logged out!';

    header('Content-Type: application/json');
    echo json_encode($response);
}

function cleanErrorMessage($errorMessage)
{
    //clean the error message, or the format is wrong
    return trim(preg_replace('/\s+/', ' ', $errorMessage));
}
?>