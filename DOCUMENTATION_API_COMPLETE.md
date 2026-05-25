# Documentation API - Gestion des Abonnés et Factures

## 📋 Table des Matières

1. [Vue d'ensemble](#vue-densemble)
2. [Configuration](#configuration)
3. [Authentification](#authentification)
4. [Endpoints API](#endpoints-api)
5. [Modèles de données](#modèles-de-données)
6. [Tests](#tests)
7. [Exemples d'utilisation](#exemples-dutilisation)

---

## 🎯 Vue d'ensemble

API REST sécurisée pour la gestion des abonnés et de leurs factures de consommation d'eau. L'API utilise Laravel Sanctum pour l'authentification par token.

### Technologies utilisées
- **Framework**: Laravel 11
- **Base de données**: MySQL
- **Authentification**: Laravel Sanctum
- **Tests**: PHPUnit
- **Validation**: Laravel Validation

### Statistiques
- ✅ **26 tests** passent avec succès
- 🔒 **Sécurité**: Tous les endpoints protégés par authentification
- 📊 **3 contrôleurs**: Auth, Abonné, Facture
- 🗄️ **2 modèles principaux**: Abonne, Facture

---

## ⚙️ Configuration

### Prérequis
- PHP 8.2+
- MySQL 8.0+
- Composer
- WampServer (ou équivalent)

### Installation

```bash
# Cloner le projet
cd evaluation_SN

# Installer les dépendances
composer install

# Configurer l'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate

# Configurer la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evaluation_sn
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_password

# Créer la base de données
php create-database.php

# Exécuter les migrations
php artisan migrate:fresh --seed

# Lancer les tests
php artisan test
```

### Base de données

La base de données contient les tables suivantes:
- `users` - Utilisateurs de l'API
- `personal_access_tokens` - Tokens d'authentification Sanctum
- `abonnes` - Abonnés au service d'eau
- `factures` - Factures de consommation

---

## 🔐 Authentification

L'API utilise **Laravel Sanctum** avec des tokens Bearer pour l'authentification.

### Endpoints d'authentification

#### 1. Inscription (Register)

**POST** `/api/register`

**Body (JSON)**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Réponse (201)**:
```json
{
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2026-03-09T22:00:00.000000Z",
    "updated_at": "2026-03-09T22:00:00.000000Z"
  },
  "token": "1|abcdef123456..."
}
```

#### 2. Connexion (Login)

**POST** `