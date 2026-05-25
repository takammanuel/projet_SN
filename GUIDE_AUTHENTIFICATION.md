# Guide d'Authentification API avec Laravel Sanctum

## 📋 Vue d'ensemble

Votre API est maintenant sécurisée avec Laravel Sanctum. Toutes les routes des abonnés et factures nécessitent une authentification.

## 🔐 Routes Publiques (sans authentification)

### 1. Inscription (Register)
- **URL**: `POST http://127.0.0.1:8000/api/register`
- **Headers**: 
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Body**:
```json
{
    "name": "Admin User",
    "email": "admin@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
- **Réponse**: Retourne un token d'accès

### 2. Connexion (Login)
- **URL**: `POST http://127.0.0.1:8000/api/login`
- **Headers**: 
  - `Content-Type: application/json`
  - `Accept: application/json`
- **Body**:
```json
{
    "email": "admin@example.com",
    "password": "password123"
}
```
- **Réponse**: Retourne un token d'accès

## 🔒 Routes Protégées (avec authentification)

Pour accéder aux routes protégées, vous devez inclure le token dans le header `Authorization`.

### Configuration du Header
- **Key**: `Authorization`
- **Value**: `Bearer VOTRE_TOKEN_ICI`

### 3. Profil Utilisateur
- **URL**: `GET http://127.0.0.1:8000/api/me`
- **Headers**: 
  - `Authorization: Bearer VOTRE_TOKEN`
  - `Accept: application/json`

### 4. Déconnexion (Logout)
- **URL**: `POST http://127.0.0.1:8000/api/logout`
- **Headers**: 
  - `Authorization: Bearer VOTRE_TOKEN`
  - `Accept: application/json`

### 5. Gestion des Abonnés
Toutes les routes suivantes nécessitent le header `Authorization: Bearer VOTRE_TOKEN`

- **GET** `/api/abonne` - Liste tous les abonnés
- **POST** `/api/abonne` - Créer un abonné
- **GET** `/api/abonne/{id}` - Voir un abonné
- **PUT/PATCH** `/api/abonne/{id}` - Modifier un abonné
- **DELETE** `/api/abonne/{id}` - Supprimer un abonné

### 6. Gestion des Factures
Toutes les routes suivantes nécessitent le header `Authorization: Bearer VOTRE_TOKEN`

- **GET** `/api/factures` - Liste toutes les factures
- **POST** `/api/factures` - Créer une facture
- **GET** `/api/factures/{id}` - Voir une facture
- **PUT/PATCH** `/api/factures/{id}` - Modifier une facture
- **DELETE** `/api/factures/{id}` - Supprimer une facture

## 📝 Guide Postman

### Étape 1: Créer un utilisateur
1. Créez une nouvelle requête POST
2. URL: `http://127.0.0.1:8000/api/register`
3. Headers: `Content-Type: application/json`, `Accept: application/json`
4. Body (raw, JSON):
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```
5. Cliquez sur Send
6. **COPIEZ LE TOKEN** de la réponse (champ `access_token`)

### Étape 2: Utiliser le token pour les requêtes protégées
1. Créez une nouvelle requête (ex: GET abonnés)
2. URL: `http://127.0.0.1:8000/api/abonne`
3. Onglet **Authorization**:
   - Type: `Bearer Token`
   - Token: Collez votre token
4. Headers: `Accept: application/json`
5. Cliquez sur Send

### Astuce Postman: Variables d'environnement
1. Créez un environnement Postman
2. Ajoutez une variable `auth_token`
3. Après le login, copiez le token dans cette variable
4. Dans Authorization, utilisez `{{auth_token}}`

## 🧪 Tester avec PowerShell

Utilisez le script fourni:
```powershell
powershell -ExecutionPolicy Bypass -File test-auth.ps1
```

## ⚠️ Codes d'erreur

- **401 Unauthorized**: Token manquant ou invalide
- **422 Unprocessable Entity**: Erreur de validation
- **500 Internal Server Error**: Erreur serveur

## 🔑 Sécurité

- Les tokens sont stockés dans la table `personal_access_tokens`
- Un utilisateur peut avoir plusieurs tokens actifs
- Le logout supprime uniquement le token utilisé
- Les mots de passe sont hashés avec bcrypt
