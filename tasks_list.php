<?php
require_once 'config.php';

$sql = "SELECT id, title, category, description FROM tasks";
$stmt = $pdo->query($sql);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include_once 'header.php'; ?>

    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <h2 class="text-center text-primary mb-4">Tâches en cours</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Intitulé</th>
                            <th>Catégorie</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="taskTableBody">
                        <?php
                        
                        if ($tasks) {
                            foreach ($tasks as $task) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($task['id'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($task['title'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($task['category'] ?? '') . "</td>
                                        <td>" . htmlspecialchars($task['description'] ?? '') . "</td>
                                        <td>
                                            <a href='Details_task.php?id=" . $task['id'] . "' class='btn btn-info btn-sm'>
                                                <i class='fas fa-eye'></i> Voir
                                            </a>
                                            <a href='edit_task.php?id=" . $task['id'] . "' class='btn btn-warning btn-sm'>
                                                <i class='fas fa-edit'></i> Modifier
                                            </a>
                                            <a href='delete.php?id=" . $task['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette tâche ?\");'>
                                                <i class='fas fa-trash-alt'></i> Supprimer
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>Aucune tâche trouvée</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3 text-center">
            <a href="insert_task.php" class="btn btn-secondary">Retour à l'ajout de nouvelle tâche</a>
        </div>
    </div>

    <?php include_once 'footer.php'; ?>
</body>
</html>
