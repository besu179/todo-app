<?php
$host = "localhost";
$dbname = "todo_app";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$id = '';
$todoName = '';
$deadline = '';
$description = '';
$error_message = '';
$success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id'])) {
        header('Location: /todo-app/index.php');
        exit;
    }

    $id = $_GET['id'];

    try {
        $stmt = $pdo->prepare('SELECT * FROM todos WHERE id = :id');
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            header('Location: /todo-app/index.php');
            exit;
        }

        $todoName = $row['name'];
        $deadline = $row['deadline'];
        $description = $row['description'];
    } catch (PDOException $e) {
        $error_message = "Error loading todo: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $todoName = $_POST['name'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    if (empty($todoName) || empty($deadline) || empty($description)) {
        $error_message = "All fields are required!";
    } else {
        try {
            $stmt = $pdo->prepare('UPDATE todos SET name = :name, description = :description, deadline = :deadline WHERE id = :id');
            $stmt->bindParam(':name', $todoName);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':deadline', $deadline);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $success_message = "Task updated successfully!";
                header("location: /todo-app/index.php");
                exit;
            } else {
                $error_message = "Failed to update task";
            }
        } catch (PDOException $e) {
            $error_message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Todo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container my-5">
    <h2>Edit Task</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($success_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Todo name</label>
            <input type="text" class="form-control" id="name" placeholder="Todo name" name="name"
                value="<?php echo htmlspecialchars($todoName); ?>" required>
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" class="form-control" id="deadline" name="deadline"
                value="<?php echo htmlspecialchars($deadline); ?>" required>
        </div>
        <div class="mb-3">
            <label for="tododescription" class="form-label">Task description</label>
            <textarea class="form-control" id="tododescription" rows="2" name="description"
                placeholder="Input description here" required><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Update Task</button>
            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</body>

</html>