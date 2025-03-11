# ToDo_App

   -----Construction-----

Après conception de l'application en local sur windows, s'assurer que docker est bien installé sur le liveServer Ubuntu
après s'être connecté avec Putty. Copiez le dossier dans le Share Folders. Modifier les droits d'accès avec les commandes
suivantes :
    -- chown -R 999 ./db
    -- chgrp -R 999 ./db

    -- chown -R 999 .ToDo_App
    -- chgrp -R 999 .ToDo_App

L'on rencontre une erreur dans l'éxécution quand les fichiers restent dans le Share Folders. Déplacez les élémnets du dossier
dans un autre dossier directement créé sur le le liveServer avec : 
    -- mkdir ToDo_App   
Faire -- ls -la après avoir changé les droits de lecture.

Pour construire l'image Docker de l'application, nous allons éxécuter la commande suivante dans le répertoire du projet:
    -- docker build -t todoApp.
S'assurer que le dockerfile s'y trouve également.

Exécuter la commande:  -- docker run --detach --port 8080:80 todoApp
On peut ouvrir le navigateur pour vérifier si l'interface graphique d'une page apparait.

-----Déploiement-----

L'application utilise la base de données db écrit avec MySQL et un serveur web. Pour faciliter la gestion des services, nous allons utiliser docker-compose.yml. S'Assurez que docker-compose est installé. Sinon procédé à son installation avec: 
-- sudo apt install docker-compose-plugin   puis vérifier l'installation avec -- docker-compose version
Pour déployer l'application avec la base de donnée, nous allons éxécuyter la commande suivante:
-- docker-compose up --detach

-----Tests-----

L'application peut-être tester avec curl ou Postman. Taper les commandes suivantes pour faires les différents tests unitaires:
3.1 Ajout d'une tâche:
-- curl -X POST http://localhost:8080/task?description=Une_description_ici

3.2 Affichage de toutes les tâches:
-- curl -X GET http://localhost:8080/task

3.3 Affichage de toutes les tâches:
-- curl -X GET http://localhost:8080/task/ID

3.4 Supprimer une tâche:
-- curl -X DELETE http://localhost:8080/task/ID

NB: ## C'est sensible à la casse donc veiller à mettre les bons caractères.


