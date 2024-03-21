<?php
require_once 'connect.php'; // Ensure you have the database connection
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['list_name'])) {
    $listName = trim($_POST['list_name']);

    // Basic validation
    if (!empty($listName)) {
        // Prepare an insert statement
        $sql = "INSERT INTO task_lists (name) VALUES (:name)";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);

            // Set parameters
            $param_name = $listName;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Record creation success
                $_SESSION['message'] = "List created successfully.";
            } else{
                $_SESSION['message'] = "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        unset($stmt);
    } else {
        $_SESSION['message'] = "Please enter the name of the list.";
    }

    // Close connection
    unset($pdo);

    // Redirect to index page
    header("Location: index.php");
    exit();
} else {
    // Not a POST request, redirect to index.php
    header("Location: index.php");
    exit();
}
?>
