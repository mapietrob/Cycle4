<?php
require_once 'connect.php'; // Database connection
session_start();

if (isset($_GET['list_id'])) {
    $listId = $_GET['list_id'];

    // Start transaction
    $pdo->beginTransaction();

    try {
        // Delete tasks associated with the list
        $sql = "DELETE FROM tasks WHERE list_id = :list_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':list_id', $listId, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the list
        $sql = "DELETE FROM task_lists WHERE id = :list_id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':list_id', $listId, PDO::PARAM_INT);
        $stmt->execute();

        // Commit the transaction
        $pdo->commit();

        $_SESSION['message'] = "List and associated tasks deleted successfully.";
    } catch (Exception $e) {
        // An error occurred, rollback changes
        $pdo->rollBack();
        $_SESSION['message'] = "Error: could not delete the list. Please try again.";
    }

    // Close statement
    unset($stmt);

    // Close connection
    unset($pdo);

    // Redirect to index.php or another appropriate page
    header("Location: index.php");
    exit();
} else {
    // No list ID provided, redirect to index.php or show an error
    $_SESSION['message'] = "Error: No list ID provided.";
    header("Location: index.php");
    exit();
}
?>
