# Welcome to Gaumont Symfony!
## Installation 
### Commande à exécuter à la racine du projet 
Lancement du container docker mysql et phpmyadmin



    docker-compose up -d

### Commande à exécuter dans le dossier /www
Installation des dépendances du projet

    composer install
    yarn install
Compilation des assets

   yarn encore dev
   bin/console assets:install
   
 Création de la base de donnée

    bin/console d:d:c
Update du schéma sql 

    bin/console d:s:u -f
Insertion des fixtures en BDD

    bin/console d:f:l
Lancement du serveur de développement

    bin/console s:r

### Utilisateurs disponibles
**Basic user** 

    mail : user@user.fr
    passworrd : user

 **Admin user**
 

    mail : admin@admin.fr
    password: admin
