<?php
require_once 'connect.php'; // Include database connection
session_start();

// Check if the task ID is set
if (isset($_GET['task_id'])) {
    $taskId = $_GET['task_id'];

    // Prepare a delete statement
    $sql = "DELETE FROM tasks WHERE id = :task_id";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Task deletion success
            $_SESSION['message'] = "Task deleted successfully.";
        } else {
            // Task deletion failed
            $_SESSION['message'] = "Error: could not delete the task. Please try again.";
        }
    }

    // Close statement
    unset($stmt);

    // Redirect to index.php or another appropriate page
    header("Location: index.php"); // Adjust as necessary
    exit();
} else {
    // No task ID provided, redirect or error handling
    $_SESSION['message'] = "Error: No task ID provided.";
    header("Location: index.php"); // Adjust as necessary
    exit();
}
?>
