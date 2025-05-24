<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo-app</title>
    <li nk rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css
">
</head>

<body class="container my-5">
    <h1>Todo list</h1>
    <a href="/todo-app/add_task.php" class="btn btn-success">Create new Task</a>
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

    $sql = "SELECT * FROM todos";
    $result = $pdo->query($sql);

    if (!$result) {
        die("invalid query" . $pdo->errorCode());
    }

    while ($row = $result->fetch()) {
        $completed = '';
        if ($row['is_complete']){
            $completed = ' completed!';
        } else {
            $completed = ' not completed!';
        }
        echo '<div class="card">
        <div class="card-body">
            <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
            <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
            <a href="edit.php?id=' . $row['id'] . '" class="btn btn-primary">Edit</a>
            <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger" 
               onclick=" return confirm( \'Are you sure you want to delete this task?\')">Delete</a>
        </div>
        <div class="card-header">
            Deadline: ' . htmlspecialchars($row['deadline']) . " This task is " .$completed .'
        </div>
    </div>';
    }

    ?>


</body>

</html>