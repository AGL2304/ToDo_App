<?php

require_once 'config.php';


if (isset($_GET['id'])) {
    $task_id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = :id";

    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':id', $task_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: tasks_list.php");
        exit;
    } else {
        echo "Une erreur est survenue lors de la suppression de la tâche.";
    }
} else {
    echo "Aucun ID de tâche spécifié.";
}
?>
