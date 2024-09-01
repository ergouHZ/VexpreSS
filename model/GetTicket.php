<?php

//get the user name from the session
$username = $_SESSION['username'];

// query the databese
$query = "SELECT * FROM tickets WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt->closeCursor();
?>