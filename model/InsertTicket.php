<?php
require 'database.php'; // Database connection

// If the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true); //get the request data and transfert the data

    // Build the query string
    $query = "INSERT INTO tickets (ticket_id, username, title, date, description) VALUES (:ticket_id, :username, :title, :date, :description)";

    try {
        // Prepare the statement
        if ($stmt = $db->prepare($query)) {

            // Get the request data
            $ticket_id = uniqid();
            $username = trim($data['user_name']);
            $title = trim($data['title']);
            $date = trim($data['date']);
            $description = trim($data['description']);

            // Bind the parameters
            $stmt->bindParam(':ticket_id', $ticket_id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':description', $description);

            if ($stmt->execute()) {
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

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}

function cleanErrorMessage($errorMessage)
{
    //clean the error message, or the format is wrong
    return trim(preg_replace('/\s+/', ' ', $errorMessage));
}
?>