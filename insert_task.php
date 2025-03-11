<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_name = $_POST['taskName'];
    $task_category = $_POST['taskCategory'];
    $task_description = $_POST['taskDescription'];

    
    if (!empty($task_name) && !empty($task_description) && !empty($task_category)) {
        try {
            
            $sql_task = "INSERT INTO tasks (title, category, description) VALUES (:title, :category, :description)";
            $stmt_task = $pdo->prepare($sql_task);
            $stmt_task->bindParam(':title', $task_name);
            $stmt_task->bindParam(':category', $task_category);
            $stmt_task->bindParam(':description', $task_description);

            if ($stmt_task->execute()) {
                header("Location: tasks_list.php");
                exit;
            } else {
                throw new Exception("Erreur lors de l'ajout de la tâche.");
            }
        } catch (Exception $e) {
            echo "Erreur: " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>To do List - App</title>
</head>
<body>
    <?php include_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary mb-4">To-Do List</h2>

            <form method="POST" action="">
                <div class="mb-3">
                    <input type="text" name="taskName" class="form-control mb-2" placeholder="Nom de la tâche" required>
                    <input type="text" name="taskCategory" class="form-control mb-2" placeholder="Catégorie de la tâche" required>
                    <textarea name="taskDescription" class="form-control mb-2" rows="2" placeholder="Description de la tâche" required></textarea>
                    <button type="submit" class="btn btn-primary w-100">Ajouter</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="tasks_list.php" class="btn btn-info">Voir toutes les tâches</a>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>
