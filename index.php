<?php
$pageTitle = 'Home - To-Do List Application'; // Dynamic page title
$pageName = 'Welcome to Your To-Do List'; // Set a page name for the header
require_once 'header.php'; // Include the header file
require_once 'connect.php'; // Database connection
session_start();

// Display message from session if any
$message = isset($_SESSION['message']) ? $_SESSION['message'] : '';
unset($_SESSION['message']); // Clear message after displaying

// Check for form submission to create a new list
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['list_name'])) {
    $listName = trim($_POST['list_name']);
    // Basic validation and sanitation
    if (!empty($listName)) {
        // Prepare SQL to prevent SQL injection
        $stmt = $pdo->prepare("INSERT INTO task_lists (name) VALUES (:name)");
        $stmt->execute([':name' => $listName]);
        $_SESSION['message'] = "List '{$listName}' created successfully!";
        header('Location: index.php'); // Redirect to prevent form resubmission
        exit;
    } else {
        $message = 'Please enter a list name.';
    }
}

// Fetch all task lists
$stmt = $pdo->query("SELECT id, name FROM task_lists");
$taskLists = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- User feedback -->
<?php if (!empty($message)): ?>
    <div><?php echo $message; ?></div>
<?php endif; ?>

<!-- Introduction section -->
<section>
    <p>Welcome to the To-Do List Application! This is your go-to app for organizing and tracking your daily tasks efficiently.</p>
</section>

<!-- Form to create a new task list -->
<section>
    <h3>Create a New Task List</h3>
    <form action="index.php" method="post">
        <input type="text" name="list_name" placeholder="List Name" required>
        <button type="submit">Create List</button>
    </form>
</section>

<!-- Section to list existing task lists with options -->
<section>
    <h3>Your Task Lists</h3>
    <ul>
        <?php if (!empty($taskLists)): ?>
            <?php foreach ($taskLists as $list): ?>
                <li class="task-list-item">
                    <div class="task-list-header">
                        <span class="task-list-name"><?php echo htmlspecialchars($list['name']); ?></span>
                        <!-- Place for the Delete button for the task list -->
                        <a href="delete_list.php?list_id=<?php echo $list['id']; ?>" class="delete-btn-list">Delete List</a>
                    </div>
                    <!-- Form to add a task to this list -->
                    <form action="create_task.php" method="post" class="add-task-form">
                        <input type="hidden" name="list_id" value="<?php echo $list['id']; ?>">
                        <input type="text" name="task_description" placeholder="Enter task">
                        <button type="submit">Add Task</button>
                    </form>
                    <ul class="task-list">
                        <?php
                        $stmt = $pdo->prepare("SELECT id, task, status FROM tasks WHERE list_id = :list_id ORDER BY id DESC");
                        $stmt->execute([':list_id' => $list['id']]);
                        $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (!empty($tasks)):
                            foreach ($tasks as $task): ?>
                                <li class="<?php echo $task['status'] === 'completed' ? 'task-completed' : 'task-item'; ?>">
                                    <div class="task-content">
                                        <form action="mark_task_complete.php" method="post" class="task-action-form">
                                            <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                                            <input type="checkbox" name="completed" onchange="this.form.submit()" <?php echo $task['status'] === 'completed' ? 'checked' : ''; ?>>
                                            <span class="task-text"><?php echo htmlspecialchars($task['task']); ?></span>
                                        </form>
                                        <a href="delete_task.php?task_id=<?php echo $task['id']; ?>" class="delete-btn-task">Delete</a>
                                    </div>
                                </li>
                            <?php endforeach;
                        else: ?>
                            <li>No tasks found.</li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No task lists found.</li>
        <?php endif; ?>
    </ul>
</section>

<?php
require_once 'footer.php'; // Include the footer file
?>
