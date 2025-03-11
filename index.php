<?php
ob_start(); // Démarre la mise en tampon de sortie
require_once 'config.php';

$URL = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

// Récupérer la méthode, le chemin et les paramètres
$METHODE = $_SERVER['REQUEST_METHOD'];
$CHEMIN = $URL[0] ?? null;
$PARAMETRE = $URL[1] ?? null;

header('Content-Type: application/json');

// Vérifier si la ressource demandée est "task"
if ($CHEMIN === "task" || ($METHODE === 'POST' && str_contains($CHEMIN, "task"))) {
    if ($METHODE === 'GET') {
        if ($PARAMETRE === null) {
            // Récupération de toutes les tâches
            $sql = "SELECT id, description FROM tasks";
            $stmt = $pdo->query($sql);
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            exit;
        } elseif (filter_var($PARAMETRE, FILTER_VALIDATE_INT)) {
            // Récupération de la tâche spécifique par l'ID
            $sql = "SELECT id, description FROM tasks WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $PARAMETRE]);
            $task = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($task) {
                echo json_encode($task, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            } else {
                http_response_code(404);
                echo json_encode(["error" => "Task not found"]);
            }
            exit;
        } else {
            http_response_code(400);
            echo json_encode(["error" => "Invalid task ID"]);
            exit;
        }
    }
    elseif ($METHODE === 'POST') {
        $PARAMETRE = explode('=',explode('?',$CHEMIN)[1]);
        try {
            $sql = 'INSERT INTO tasks(description) VALUE(:description)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['description' => $PARAMETRE[1]]);            
        
            if ($stmt->rowCount() > 0) {

                $sql = "SELECT id, description FROM tasks order by id desc LIMIT 1";
                $stmt = $pdo->query($sql);
                $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($tasks) {
                    // Définir l'en-tête Location avec l'ID de la tâche créée
                    header("Location: http://localhost/task/".$tasks[0]['id']);

                    echo json_encode($tasks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    http_response_code(200);
                } else {
                    http_response_code(404);
                    echo json_encode(["error" => "Task not found"]);
                }
                return;
            } else {
                $response = ["status" => "warning", "message" => "Task not found or already deleted"];
                echo json_encode($response, flags: JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }
        } catch (PDOException $e) {
            $response = ["status" => "error", "message" => "Database error: " . $e->getMessage()];
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
    }
    elseif($METHODE === 'DELETE')
    {
        try {
            $sql = "DELETE FROM tasks WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['id' => $PARAMETRE]);
        
            if ($stmt->rowCount() > 0) {
                http_response_code(200);
                return;
            } else {
                $response = ["status" => "warning", "message" => "Task not found or already deleted"];
                echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                return;
            }
        } catch (PDOException $e) {
            $response = ["status" => "error", "message" => "Database error: " . $e->getMessage()];
            echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            return;
        }
        
    }
    else {
        http_response_code(405);
        echo json_encode(["error" => "Method Not Allowed"]);
        exit;
    }
    
} else {
    http_response_code(404);
    echo json_encode(["error" => "Resource not found"]);
    exit;
}
ob_end_flush(); // Envoie la sortie tamponnée au navigateur
