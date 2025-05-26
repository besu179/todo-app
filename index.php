<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>todo-app</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css
">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="container my-5">
    <div >
        <h1>Todo list</h1>
        <a href="/todo-app/add_task.php" class="btn btn-success">Create new Task</a><br><br>
    </div>

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
        if ($row['is_complete']) {
            $completed = ' completed!';
        } else {
            $completed = ' not completed!';
        }
        echo '<div class="card bg-secondary bg-gradient" >
        <div class="card-body" style="display: flex; justify-content: space-between;">
            <div>
                <h3 class="card-title">' . htmlspecialchars($row['name']) . '</h3>
                <p class="card-text">' . htmlspecialchars($row['description']) . '</p>
            </div>
            <div>
                <a href="edit.php?id=' . $row['id'] . '" class="btn btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <a href="delete.php?id=' . $row['id'] . '" class="btn btn-danger" 
                onclick=" return confirm( \'Are you sure you want to delete this task?\')"><i class="fa-solid fa-trash"></i></a>
            </div>
        </div>
        <div class="card-header font-monospace">
            Deadline: ' . htmlspecialchars($row['deadline']) . " This task is " . $completed . '
        </div>
    </div> <br>';
    }

    ?>


</body>

</html>