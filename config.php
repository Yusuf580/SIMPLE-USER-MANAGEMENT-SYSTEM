<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "user_management";

    $conn = new mysqli($servername,$username,$password,$database);

    if($conn->connect_error){
        die("Connection failed".$conn->connect_error);
    }

    /*$sql = "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        email VARCHAR(50) NOT NULL UNIQUE,
        pass_word VARCHAR(255) NOT NULL,
        profile_pic VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Table 'users' created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();*/
    
?>