# CampShare - Plateforme de Location d'Équipement de Camping

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Figma](https://img.shields.io/badge/Figma-F24E1E?style=for-the-badge&logo=figma&logoColor=white)
<!-- Ajoutez d'autres badges si pertinent (ex: license, build status) -->

## Description

**CampShare** est une application web conçue pour mettre en relation des propriétaires d'équipements de camping (tentes, sacs de couchage, réchauds, quads, etc.) avec des personnes souhaitant louer ce matériel pour leurs aventures en plein air. La plateforme a pour but de faciliter la recherche, la réservation, le paiement sécurisé et la communication entre les utilisateurs (Clients et Partenaires).

## Objectifs

*   Fournir une solution simple et efficace pour la location de matériel de camping entre particuliers.
*   Développer une application web robuste et évolutive en utilisant Laravel et Bootstrap.
*   Offrir une expérience utilisateur fluide et sécurisée pour les locataires et les propriétaires.
*   Mettre en place un système de gestion complet incluant annonces, réservations, paiements et évaluations.

## Fonctionnalités Clés

**Pour les Clients :**
*   Rechercher des équipements par catégorie, lieu, dates, prix.
*   Consulter les détails des annonces (photos, description, notes).
*   Réserver et payer en ligne de manière sécurisée.
*   Choisir une option de livraison (si proposée par le partenaire).
*   Noter et commenter l'équipement et le partenaire après la location.
*   Gérer leurs réservations (consulter, annuler sous conditions).

**Pour les Partenaires :**
*   Créer, modifier, activer, archiver et supprimer leurs annonces d'équipement.
*   Gérer leur inventaire et les disponibilités.
*   Choisir une option d'annonce "Premium" pour plus de visibilité.
*   Recevoir des notifications de réservation.
*   Accepter ou refuser les demandes de location.
*   Consulter l'historique des locations et les fiches des clients.
*   Noter et commenter les clients après la location.
*   Recevoir les paiements via la plateforme.

**Pour les Administrateurs :**
*   Gérer les utilisateurs (clients, partenaires).
*   Modérer les annonces et les commentaires.
*   Configurer les paramètres de la plateforme.
*   Superviser les transactions et gérer les litiges.
*   Consulter les statistiques d'utilisation.

## Technologies Utilisées

*   **Backend:** PHP / Laravel Framework
*   **Frontend:** HTML5, CSS3, JavaScript, Bootstrap 5
*   **Base de Données:** MySQL
*   **Outils Collaboratifs (suggestion):** Jira, Slack
*   **Versionning:** Git, GitHub
*   **Modélisation:** UML
*   **Maquettes:** Figma

## Équipe et Rôles

*   **Chef de Projet :** BARHROUJ Saad (saad.barhrouj@etu.uae.ac.ma)
*   **Responsable Backend :** kaoutar.iabakriman@etu.uae.ac.ma
*   **Développeuse Backend :** elabida.rajae@etu.uae.ac.ma
*   **Responsable Frontend :** elhauari.imohamed@etu.uae.ac.ma
*   **Développeuse Frontend :** fatimazahraederaoui04@gmail.com
*   **Responsable Tests :** mohamed.elattaoui@etu.uae.ac.ma
*   **Responsable Sécurité :** maroun.ilias@etu.uae.ac.ma

## Installation et Lancement

1.  **Cloner le dépôt :**
    ```bash
    git clone 
    cd CampShare
    ```

2.  **Installer les dépendances PHP (via Composer) :**
    ```bash
    composer install
    ```

3.  **Installer les dépendances Frontend (via npm) :**
    ```bash
    npm install
    npm run dev # ou build pour la production
    ```

4.  **Configuration de l'environnement :**
    *   Copier le fichier d'environnement : `cp .env.example .env`
    *   Configurer les accès à la base de données (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, etc.) dans le fichier `.env`.
    *   Configurer les autres services (Mail, Paiement...).

5.  **Générer la clé d'application Laravel :**
    ```bash
    php artisan key:generate
    ```

6.  **Exécuter les migrations et seeders  :**
    ```bash
    php artisan migrate --seed
    ```

7.  **Lancer le serveur de développement :**
    ```bash
    php artisan serve
    ```

8.  **Accéder à l'application :** Ouvrez votre navigateur et allez à l'adresse `http://127.0.0.1:8000` .
