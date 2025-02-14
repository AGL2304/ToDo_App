CREATE DATABASE todo_app;
USE todo_app;

-- Table Tâches avec Catégorie intégrée
CREATE TABLE tasks (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT
);
