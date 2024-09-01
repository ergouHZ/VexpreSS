<?php
//CROS
header("Access-Control-Allow-Origin: https://8080-codeanywhere-templates-b-hbgcic273q.us1.codeanyapp.com/");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
require 'database.php';
session_start(); // I need to write the session here
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array(); //the response body
    //make the insert query
    $query = "INSERT INTO user (username, password) VALUES (:username, :password)";

    try {
        //prepare the statement
        if ($stmt = $db->prepare($query)) {


            // get user input
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // hash the password, can not hard input th password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // bind the values
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);


            // execute the statement
            if ($stmt->execute()) {
                $_SESSION['username'] = $username;
                $response['status'] = 200;
                $response['message'] = 'Register success'; //put into the response body, I want to build the response in a traditional way, to really seperate the the back and the front end

            } else {
                $response['status'] = 201;
                $response['message'] = 'Error: duplicate username'; //put into the response body
            }

            // close the statement
            $stmt->closeCursor();
        } else {
            $response['status'] = 400;
            $response['message'] = 'Error: in database';
        }
    } catch (PDOException $e) {
        ob_clean(); // clean all the input beafore
        http_response_code(500); //
        $response['status'] = 500;
        $response['message'] = 'Database Error: ' . cleanErrorMessage($e->getMessage()); 
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }catch (Exception $e) {
        ob_clean(); // clean all the input beafore
        http_response_code(500); //
        $response['status'] = 500;
        $response['message'] = 'Script Error: ' . cleanErrorMessage($e->getMessage()); // 清理错误消息并添加到响应中
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }

    // return the response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}

function cleanErrorMessage($errorMessage)
{
    //clean the error message, or the format is wrong
    return trim(preg_replace('/\s+/', ' ', $errorMessage));
}
?>