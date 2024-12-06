# Projet Symfony 7 - E-commerce de vélos

Ce projet est une application web e-commerce développée avec Symfony 7, permettant aux utilisateurs de consulter des vélos, les ajouter à leur panier et finaliser leur achat en ligne. Ce projet utilise également une base de données MySQL pour gérer les produits, les utilisateurs et les commandes.

## Installation du projet

### Prérequis

Avant de commencer, vous devez vous assurer d'avoir les éléments suivants installés sur votre machine :
- PHP 8.1 ou version supérieure
- Composer
- MySQL (ou une autre base de données compatible avec Doctrine)

### Étapes d'installation

1. **Cloner le repository** :
2. Tout d'abord, clonez le projet depuis GitHub en exécutant la commande suivante :
   ```bash
   git clone https://github.com/YoniSlh/symfony_bike.git
   ```
Installer les dépendances avec Composer :
Accédez au dossier du projet cloné et installez les dépendances nécessaires en exécutant :
 ```bash
cd symfony_bike
```
```bash
composer install
```

**Configurer votre base de données :**

Copiez le fichier .env.dist en .env :
```bash
cp .env.dist .env
```
Ouvrez le fichier .env et modifiez les paramètres de connexion à la base de données selon votre configuration locale. Par exemple :
makefile

DATABASE_URL="mysql://root:root@127.0.0.1:3306/symfony_bike?serverVersion=5.7&charset=utf8mb4"

Créer la base de données :
Après avoir configuré votre base de données, créez-la en exécutant la commande suivante :

 ```bash
php bin/console doctrine:database:create
```
Appliquer les migrations :
Une fois la base de données créée, appliquez les migrations pour mettre en place les tables nécessaires :
 
 ```bash
php bin/console doctrine:migrations:migrate
```
Lancer le serveur Symfony :
Maintenant que tout est configuré, lancez le serveur de développement Symfony avec la commande :

 ```bash
symfony server:start
```
Votre site sera accessible à l'adresse http://localhost:8000.

Utilisation du projet
Page d'accueil :
Naviguez vers la page d'accueil pour découvrir les vélos disponibles à la vente. Chaque vélo possède une image, une description, et un prix.

Ajouter un produit au panier :
Vous pouvez ajouter des vélos à votre panier en cliquant sur les boutons correspondants. Le nombre de produits ajoutés sera mis à jour en temps réel.

Consulter le panier :
Accédez à la page du panier pour voir la liste des produits que vous avez ajoutés, modifier leur quantité ou les supprimer.

Passer une commande :
Si vous êtes prêt à finaliser votre commande, vous pouvez passer à la page de commande. Vous y trouverez un résumé des produits, de leur quantité et du montant total à payer. Un bouton vous permettra de confirmer la commande.
