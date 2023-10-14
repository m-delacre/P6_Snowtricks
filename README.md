# P6_Snowtricks

*Ce projet fait partie de mon parcours de formation, l'objectif de ce projet est de créer un site communautaire où les utilisateurs peuvent créer, modifier et supprimer des articles avec des photos et des vidéos et avoir la possibilité de commenter les articles.* 

### Prérequis :

* Un serveur de bdd
* Composer
* Symfony CLI

  
## Installer le projet

Pour commencer, clonez ce projet avec la commande suivante :

```

 git clone https://github.com/m-delacre/P6_Snowtricks.git

```

Ouvrez votre terminal favori et rendez-vous dans le dossier où se trouve le clone du projet. Puis entrez cette commande : 

```

 composer install

```

## Configurer le projet

Maintenant que le projet est installé, il faut le configurer.

À la racine du projet créer un fichier .env.local et ajoutez c'est lignes avec vos options :

```env
DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8.0.32"
MAILER_DSN=smtp://user:pass@smtp.example.com:port
```

## Lancer le projet

### Pour lancer le projet :

* Lancer votre serveur de bdd
* Lancer le serveur php avec :
  ```
  
  symfony server:start
  
  ```
