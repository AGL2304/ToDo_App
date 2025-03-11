<?php
require_once 'config.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $taskId = $_GET['id'];

    $sql = "SELECT id, title, category, description FROM tasks WHERE id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
    $stmt->execute();

    $task = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    header("Location: tasks_list.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Tâche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary mb-4">Informations de la Tâche</h2>
            <div id="taskDetails" class="text-center">
                <?php if ($task): ?>
                    <p><strong>ID :</strong> <?php echo htmlspecialchars($task['id']); ?></p>
                    <p><strong>Intitulé :</strong> <?php echo htmlspecialchars($task['title']); ?></p>
                    <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($task['category']); ?></p>
                    <p><strong>Description :</strong> <?php echo nl2br(htmlspecialchars($task['description'])); ?></p>
                <?php else: ?>
                    <p class="text-danger">Cette tâche n'existe pas.</p>
                <?php endif; ?>
            </div>
            <div class="text-center mt-3">
                <a href="tasks_list.php" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>
