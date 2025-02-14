<?php
// Inclure le fichier de connexion à la base de données
require_once 'config.php';

// Vérifier si l'ID de la tâche est passé en paramètre via l'URL
if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    // Préparer la requête pour supprimer la tâche avec l'ID spécifié
    $sql = "DELETE FROM tasks WHERE id = :id";

    // Préparer la requête
    $stmt = $pdo->prepare($sql);

    // Lier l'ID à la requête
    $stmt->bindParam(':id', $task_id, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Rediriger vers la liste des tâches après la suppression
        header("Location: task_list.php");
        exit;
    } else {
        echo "Une erreur est survenue lors de la suppression de la tâche.";
    }
} else {
    echo "Aucun ID de tâche spécifié.";
}
?>
