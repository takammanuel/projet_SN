# Documentation API - Gestion des Abonnés et Factures

## Vue d'ensemble

API REST sécurisée pour la gestion des abonnés et leurs factures de consommation d'eau. L'API utilise Laravel Sanctum pour l'authentification par token.

**Base URL**: `http://localhost:8000/api`

## Authentification

### Inscription d'un utilisateur

**Endpoint**: `POST /register`

**Accès**: Public (pas d'authentification requise)

**Corps de la requête**:
```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

**Répon