<?php
require 'database.php'; //database connection

//if post to this api, then insert new order into the database, 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);


    //build the query string
    $query = "INSERT INTO orders (order_id, type, user_name, start_date, end_date, volumn_total)
     VALUES (:order_id, :type, :user_name, :start_date, :end_date, :volumn_total)";
    try {
        
        if ($stmt = $db->prepare($query)) {

            //get the request
            $order_id = uniqid();//generate unique indepedent id for database and the page
            $type = trim($data['type']);
            $user_name = trim($data['user_name']);
            $start_date = trim($data['start_date']);
            $end_date = trim($data['end_date']);
            $volumn_total = trim($data['volumn_total']);
            
            
            //bind the parameters
            $stmt->bindParam(':order_id', $order_id);
            $stmt->bindParam(':type', $type);
            $stmt->bindParam(':user_name', $user_name);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->bindParam(':volumn_total', $volumn_total);

            if ($stmt->execute()) {  //excute the query
                $response['status'] = 200;
                $response['message'] = 'Data inserted successfully';
            } else {
                $response['status'] = 400;
                $response['message'] = 'Error: Failed to insert data';
            }

            $stmt->closeCursor();
        } else {
            $response['status'] = 401;
            $response['message'] = 'Error: Database error';
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

    //return json response
    header('Content-Type: application/json');
    echo json_encode($response);
}

function cleanErrorMessage($errorMessage)
{
    //clean the error message, or the format is wrong
    return trim(preg_replace('/\s+/', ' ', $errorMessage));
}
?>