<?php

//get the user name from the session
$username = $_SESSION['username'];

// query the databese
$query = "SELECT * FROM orders WHERE user_name = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt->closeCursor();
?>