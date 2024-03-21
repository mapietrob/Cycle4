<?php
require_once 'connect.php'; // Database connection
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_description'], $_POST['list_id'])) {
    $taskDescription = trim($_POST['task_description']);
    $listId = $_POST['list_id'];

    // Validate input
    if (!empty($taskDescription) && !empty($listId)) {
        // Prepare an insert statement
        $sql = "INSERT INTO tasks (list_id, task, status) VALUES (:list_id, :task, 'pending')";

        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':list_id', $param_list_id, PDO::PARAM_INT);
            $stmt->bindParam(':task', $param_task);

            // Set parameters
            $param_list_id = $listId;
            $param_task = $taskDescription;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Task creation success
                $_SESSION['message'] = "Task added successfully.";
            } else {
                $_SESSION['message'] = "Error: could not add the task. Please try again.";
            }
        }

        // Close statement
        unset($stmt);
    } else {
        $_SESSION['message'] = "Please fill in all required fields.";
    }

    // Close connection
    unset($pdo);

    // Redirect to a specific page, adjust the location as needed
    header("Location: index.php"); // Or redirect to a specific task list view
    exit();
} else {
    // Not a POST request, redirect to index.php or a relevant page
    header("Location: index.php");
    exit();
}
?>
