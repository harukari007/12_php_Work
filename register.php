<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $membership = $_POST['membership'];

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, membership) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $username, $email, $password, $membership);

    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
