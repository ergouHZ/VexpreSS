<?php
require 'database.php';
session_start(); //this is needed to read the username

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = array();
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $password = trim($_POST['password']);

    try {
        //get the username in the user session
        $username = $_SESSION['username'];

        // prepare the query statement
        $updateFields = array();
        $params = array(':username' => $username);

        if (!empty($email)) {
            $updateFields[] = "email = :email";
            $params[':email'] = $email;
        }

        if (!empty($phone)) {
            $updateFields[] = "phone = :phone";
            $params[':phone'] = $phone;
        }

        if (!empty($password)) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateFields[] = "password = :password";
            $params[':password'] = $hashedPassword;
        }

        if (!empty($updateFields)) {
            $query = "UPDATE user SET " . implode(", ", $updateFields) . " WHERE username = :username";
            $stmt = $db->prepare($query);
            $stmt->execute($params);

            $response['status'] = 200;
            $response['message'] = 'Profile updated successfully';
        } else {
            $response['status'] = 200;
            $response['message'] = 'No changes made';
        }
    } catch (PDOException $e) {
        ob_clean(); // clean all the input beafore
        http_response_code(500); //
        $response['status'] = 500;
        $response['message'] = 'Database Error: ' . cleanErrorMessage($e->getMessage()); // clean the error message
        header('Content-Type: application/json');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    $stmt->closeCursor();
    header('Content-Type: application/json');
    echo json_encode($response);
}

function cleanErrorMessage($errorMessage)
{
    //clean the error message, or the format is wrong
    return trim(preg_replace('/\s+/', ' ', $errorMessage));
}
?>