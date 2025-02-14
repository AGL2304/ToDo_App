<?php
require_once 'config.php';

// Vérifier si l'ID de la tâche est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $taskId = $_GET['id'];

    // Récupérer la tâche à modifier
    $sql = "SELECT id, title, category, description FROM tasks WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);
    $stmt->execute();
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier si la tâche existe
    if (!$task) {
        echo "Tâche introuvable.";
        exit;
    }
} else {
    echo "Aucune tâche à modifier.";
    exit;
}

// Traiter la soumission du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $task_name = $_POST['taskName'];
    $task_description = $_POST['taskDescription'];
    $task_category = $_POST['taskCategory'];

    // Vérifier que les champs sont remplis
    if (!empty($task_name) && !empty($task_description) && !empty($task_category)) {
        // Mettre à jour la tâche
        $sql = "UPDATE tasks SET title = :title, description = :description, category = :category WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Lier les paramètres
        $stmt->bindParam(':title', $task_name);
        $stmt->bindParam(':description', $task_description);
        $stmt->bindParam(':category', $task_category);
        $stmt->bindParam(':id', $taskId, PDO::PARAM_INT);

        // Exécuter la requête
        if ($stmt->execute()) {
            header("Location: task_list.php");
            exit;
        } else {
            echo "Erreur lors de la modification de la tâche.";
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
    <title>Modifier la Tâche</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary mb-4">Modifier la Tâche</h2>

            <!-- Formulaire de modification -->
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="taskName" class="form-label">Nom de la tâche</label>
                    <input type="text" name="taskName" id="taskName" class="form-control" value="<?php echo htmlspecialchars($task['title']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="taskCategory" class="form-label">Catégorie</label>
                    <input type="text" name="taskCategory" id="taskCategory" class="form-control" value="<?php echo htmlspecialchars($task['category']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="taskDescription" class="form-label">Description de la tâche</label>
                    <textarea name="taskDescription" id="taskDescription" class="form-control" rows="3" required><?php echo htmlspecialchars($task['description']); ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Enregistrer les modifications</button>
            </form>

            <div class="text-center mt-3">
                <a href="task_list.php" class="btn btn-secondary">Retour à la liste des tâches</a>
            </div>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>
