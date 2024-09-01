<?php

//get the user name from the session
$username = $_SESSION['username'];

// query the databese
$query = "SELECT * FROM user WHERE username = :username";
$stmt = $db->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt->closeCursor();
?>