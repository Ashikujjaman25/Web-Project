<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $destination = isset($_POST['destination']) ? $_POST['destination'] : '';
    $departure_date = isset($_POST['departure-date']) ? $_POST['departure-date'] : '';
    $return_date = isset($_POST['return-date']) ? $_POST['return-date'] : '';
    $travel_modes = isset($_POST['travel-mode']) ? implode(", ", $_POST['travel-mode']) : '';

    // Database connection parameters
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "reg";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO user (name, email, destination, departure_date, return_date, travel_modes) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
        $stmt->bind_param("ssssss", $name, $email, $destination, $departure_date, $return_date, $travel_modes);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Booking Complete.";
        } else {
            echo "Execute failed: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo "No data submitted.";
}
?>
