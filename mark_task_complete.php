<?php
require_once 'connect.php'; // Database connection
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $taskId = $_POST['task_id'];
    $newStatus = isset($_POST['completed']) ? 'completed' : 'pending'; // Determine new status

    // Prepare the update statement
    $sql = "UPDATE tasks SET status = :status WHERE id = :task_id";

    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(':status', $newStatus);
        $stmt->bindParam(':task_id', $taskId, PDO::PARAM_INT);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Set success message
            $_SESSION['message'] = "Task status updated successfully.";
        } else {
            // Set error message in case of failure
            $_SESSION['message'] = "Error updating task status. Please try again.";
        }
    } else {
        // Set error message if the statement couldn't be prepared
        $_SESSION['message'] = "Error preparing database statement.";
    }

    // Close statement
    unset($stmt);

    // Redirect back to index.php
    header("Location: index.php");
    exit();
} else {
    // Set error message if task_id isn't set
    $_SESSION['message'] = "Error: No task ID provided.";
    header("Location: index.php");
    exit();
}

