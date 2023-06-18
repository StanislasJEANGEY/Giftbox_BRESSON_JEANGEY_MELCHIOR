# Giftbox - Projet d'architecture logiciel

### Membres :
- Damien MELCHIOR
- Jules BRESSON
- Stanislas JEANGEY

# ! A l'intention du correcteur !
Nous avons rencontré des problèmes de stabilité sur docketu. Les dockers en cours d'exécution venaient à 
planter et impossible d'y accéder, ni de les redémarrer. Obligé de demander l'intervention de l'administrateur
réseau pour arrêter de forces les services docker et les redémarrer. Nous allons voir ce problème en détail 
avec l'administrateur réseau lundi 19/06 pour que la correction (et également la SAE) se déroule sans encombres.  
Merci de votre compréhension.

### URL docketu : 
htttp://docketu.iutnc.univ-lorraine.fr:18080

<br>

### URL dépôt git : 
https://github.com/StanislasJEANGEY/Giftbox_BRESSON_JEANGEY_MELCHIOR.git

<br>

### Installation et mise en place du projet :
1. Cloner le dépôt git
2. Aller sur son serveur de base de données et créer une base de données nommée `giftbox`
3. Importer le fichier `giftbox.schema.sql` dans la base de données `giftbox` puis le fichier `giftbox.data.sql`
4. Remplir les fichiers `gift.db.conf.ini` qui se trouve dans le dossier `gift/gift.api/src/conf/` et `gift/gift.appli/src/conf/` avec les informations de connexion à votre base de données
5. Configurer son serveur web pour qu'il pointe vers le dossier `public` du projet (que ce soit pour l'api ou l'appli)

<br>

Identifiants de connexion sur notre application Giftbox :
- Admin : 
  - Identifiant : admin@mail.com
  - Mot de passe : admin
- User : 
  - Identifiant : user@mail.com
  - Mot de passe : user

<br>

### Fonctionnalités du projet :
| Fonctionnalités                                            |          Auteur          | Status |
|------------------------------------------------------------|:------------------------:|:------:|
| 1. Afficher la liste des prestations                       |          Jules           |   OK   |
| 2. Afficher le détail d'une prestation                     |      Damien, Jules       |   OK   | 
| 3. Liste de prestations par catégories                     |        Stanislas         |   OK   |
| 4. Liste de catégories                                     |        Stanislas         |   OK   |
| 5. Tri par prix                                            |          Damien          |   OK   |
| 6. Création d'un coffret vide                              |      Damien, Jules       |   OK   |
| 7. Ajout de prestations dans le coffret                    |        Stanislas         |   OK   |
| 8. Affichage d'un coffret                                  |          Damien          |   OK   |
| 9. Validation d'un coffret                                 | Jules, Damien, Stanislas |   OK   |
| 10. Paiement d'un coffret                                  |          Damien          |   OK   |
| 11. Modification d'un coffret : suppression de prestations |        Stanislas         |   OK   |
| 12. Modification d'un coffret : modification des quantités |        Stanislas         |   OK   |
| 13. Génération de l'URL d'accès                            |          Jules           |   OK   |
| 14. Accès au coffret                                       |        Stanislas         |   OK   |
| 15. Signin                                                 |          Jules           |   OK   |
| 16. Register                                               |          Jules           |   OK   |
| 17. Accéder à ses coffrets                                 |        Stanislas         |   OK   |
| 18. Afficher les box prédéfinies                           |          Damien          |   OK   |
| 19. Créer un coffret prérempli à partir d'une box          |        Stanislas         |   OK   |
| 21. Api : liste des prestations                            |        Stanislas         |   OK   |
| 20. Créer un coffret prérempli à partir d'une box affichée |        Stanislas         |   OK   |
| 22. Api : liste des catégories                             |        Stanislas         |   OK   |
| 23. Api : liste des prestations d'une catégorie            |        Stanislas         |   OK   |
| 24. Api : accès à un coffret                               |        Stanislas         |   OK   |
