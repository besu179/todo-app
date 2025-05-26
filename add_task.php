<?php
$todoName = '';
$deadline = '';
$description = '';


$error_message = '';
$success_message = '';

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



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $todoName = $_POST['name'];
    $deadline = $_POST['deadline'];
    $description = $_POST['description'];

    if (empty($todoName) || empty($deadline) || empty($description)) {
        $error_message = "All fields are required!";
    } else {

        //insert into database
        $sql = "INSERT INTO todos(name, description, deadline )" . "VALUES('$todoName', '$description' , '$deadline')";
        $result = $pdo->query($sql);

        if (!$result) {
            $error_message = ("invalid query");
        }

        $success_message = 'Task added successfully!';

        header("location: /todo-app/index.php");
        exit;

        $todoName = '';
        $deadline = '';
        $description = '';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add todo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container my-5">

    <h2>Add New Task</h2>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $error_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $success_message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Todo name</label>
            <input type="text" class="form-control" id="name" placeholder="Todo name" name="name" value="<?php echo htmlspecialchars($todoName); ?>">
        </div>
        <div class="mb-3">
            <label for="deadline" class="form-label">Deadline</label>
            <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo htmlspecialchars($deadline); ?>">
        </div>
        <div class="mb-3">
            <label for="tododescription" class="form-label">Task description</label>
            <textarea class="form-control" id="tododescription" rows="2" name="description" placeholder="Input description here"><?php echo htmlspecialchars($description); ?></textarea>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-success">Add task</button>
            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</body>

</html>