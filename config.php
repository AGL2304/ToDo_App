<?php
// Paramètres de connexion
$host = "localhost"; // Adresse du serveur MySQL (127.0.0.1 si en local)
$dbname = "todo_app"; // Nom de la base de données
$username = "root"; // Nom d'utilisateur MySQL (à modifier si besoin)
$password = ""; // Mot de passe MySQL (laisser vide si en local)

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Configuration pour afficher les erreurs PDO
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
