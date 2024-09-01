<?php
require 'database.php'; // Database connection
//CROS
header("Access-Control-Allow-Origin: https://8080-codeanywhere-templates-b-hbgcic273q.us1.codeanyapp.com/");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
// If the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true); //get the request data and transfer the data

    // Build the query string
    $query = "DELETE FROM tickets WHERE ticket_id = :ticket_id";

    try {
        // Prepare the statement
        if ($stmt = $db->prepare($query)) {

            // Get the request data
            $ticket_id = trim($data['ticket_id']);

            // Bind the parameter
            $stmt->bindParam(':ticket_id', $ticket_id);

            if ($stmt->execute()) {
                $response['status'] = 200;
                $response['message'] = 'Data deleted successfully';
            } else {
                $response['status'] = 400;
                $response['message'] = 'Error: Failed to delete data';
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