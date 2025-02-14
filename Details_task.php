<?php
require_once 'config.php';

// Vérifier si l'ID de la tâche est passé en paramètre dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $taskId = $_GET['id'];

    // Préparer la requête pour récupérer les informations de la tâche avec l'ID correspondant
    $sql = "SELECT tasks.id, tasks.title, tasks.description, categories.name AS category 
            FROM tasks 
            LEFT JOIN categories ON tasks.category_id = categories.id
            WHERE tasks.id = :id";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
    $stmt->execute();

    // Vérifier si une tâche a été trouvée
    $task = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // Rediriger vers la liste des tâches si l'ID n'est pas trouvé
    header("Location: task_list.php");
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
                    <p><strong>ID :</strong> <?php echo $task['id']; ?></p>
                    <p><strong>Intitulé :</strong> <?php echo $task['title']; ?></p>
                    <p><strong>Catégorie :</strong> <?php echo $task['category']; ?></p>
                    <p><strong>Description :</strong> <?php echo $task['description']; ?></p>
                <?php else: ?>
                    <p>Cette tâche n'existe pas.</p>
                <?php endif; ?>
            </div>
            <div class="text-center mt-3">
                <a href="task_list.php" class="btn btn-secondary">Retour à la liste</a>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>

</body>
</html>
