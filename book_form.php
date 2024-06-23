<?php

$connection = mysqli_connect('localhost', 'root', '', 'book_db');

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['send'])) {
    // Validate and sanitize user input
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $location = htmlspecialchars($_POST['location']);
    $guests = htmlspecialchars($_POST['guests']);
    $arrival = htmlspecialchars($_POST['arrival']);
    $leaving = htmlspecialchars($_POST['leaving']);

    // Use prepared statements to prevent SQL injection
    $stmt = $connection->prepare("INSERT INTO book_form (name, email, phone, address, location, guests, arrival, leaving) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("ssssssss", $name, $email, $phone, $address, $location, $guests, $arrival, $leaving);

        if ($stmt->execute()) {
            // Redirect to a success page after successful insertion
            header('Location: book.php');
            exit();
        } else {
            // Display an error message if insertion fails
            echo 'Something went wrong, please try again later.';
        }

        $stmt->close();
    } else {
        // Display an error message if prepared statement fails
        echo 'Prepared statement failed: ' . $connection->error;
    }
}

mysqli_close($connection);

?>
