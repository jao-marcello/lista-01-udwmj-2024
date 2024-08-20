<?php
require 'config.php';

if (isset($_POST['add_task'])) {
    $title = $_POST['title'];
    if (!empty($title)) {
        $stmt = $pdo->prepare("INSERT INTO tasks (title) VALUES (:title)");
        $stmt->execute(['title' => $title]);
    }
}

if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    $stmt = $pdo->prepare("UPDATE tasks SET completed = 1 WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

$stmt = $pdo->prepare("SELECT * FROM tasks");
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        li.completed {
            text-decoration: line-through;
            color: #888;
        }

        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <h1>To-Do List</h1>
    <form method="POST" action="">
        <input type="text" name="title" placeholder="Digite uma nova tarefa" required>
        <button type="submit" name="add_task">Adicionar</button>
    </form>

    <ul>
        <?php foreach ($tasks as $task): ?>
            <li class="<?php echo $task['completed'] ? 'completed' : ''; ?>">
                <?php echo htmlspecialchars($task['title']); ?>
                <div class="actions">
                    <?php if (!$task['completed']): ?>
                        <a href="?complete=<?php echo $task['id']; ?>">Completar</a>
                    <?php endif; ?>
                    <a href="?delete=<?php echo $task['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')">Excluir</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
