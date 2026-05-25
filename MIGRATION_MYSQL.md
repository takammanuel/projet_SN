# 🔄 Guide de Migration SQLite vers MySQL

## Problème rencontré

L'utilisateur `root` de MySQL dans WampServer n'a pas tous les privilèges nécessaires.

## ✅ Solution 1: Via phpMyAdmin (Recommandé)

### Étape 1: Accorder les privilèges

1. **Ouvrez phpMyAdmin**: `http://localhost/phpmyadmin`

2. **Cliquez sur l'onglet "Comptes utilisateurs"** en haut

3. **Trouvez l'utilisateur `root`** avec l'hôte `localhost`

4. **Cliquez sur "Modifier les privilèges"**

5. **Dans la section "Privilèges globaux"**:
   - Cliquez sur **"Tout cocher"**
   - Assurez-vous que toutes les cases sont cochées

6. **Cliquez sur "Exécuter"** en bas de la page

### Étape 2: Lancer les migrations

```bash
php artisan migrate:fresh --seed
```

---

## ✅ Solution 2: Créer un nouvel utilisateur

Si vous ne pouvez pas modifier les privilèges de root, créez un nouvel utilisateur.

### Via phpMyAdmin

1. Ouvrez phpMyAdmin: `http://localhost/phpmyadmin`

2. Cliquez sur **"Comptes utilisateurs"**

3. Cliquez sur **"Ajouter un compte d'utilisateur"**

4. Remplissez:
   - **Nom d'utilisateur**: `laravel`
   - **Nom d'hôte**: `localhost`
   - **Mot de passe**: `laravel123`
   - **Re-saisir**: `laravel123`

5. Dans **"Privilèges globaux"**:
   - Cochez **"Tout cocher"**

6. Cliquez sur **"Exécuter"**

### Modifier le fichier .env

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evaluation_sn
DB_USERNAME=laravel
DB_PASSWORD=laravel123
```

### Lancer les migrations

```bash
php artisan config:clear
php artisan migrate:fresh --seed
```

---

## ✅ Solution 3: Via la console MySQL de WampServer

### Étape 1: Ouvrir la console MySQL

1. Cliquez sur l'icône **WampServer** dans la barre des tâches
2. Allez dans **MySQL** → **Console MySQL**
3. Appuyez sur **Entrée** (le mot de passe est vide par défaut)

### Étape 2: Exécuter les commandes

```sql
-- Accorder tous les privilèges
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'root'@'localhost';
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'root'@'127.0.0.1';
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'root'@'%';

-- Recharger les privilèges
FLUSH PRIVILEGES;

-- Quitter
EXIT;
```

### Étape 3: Lancer les migrations

```bash
php artisan migrate:fresh --seed
```

---

## ✅ Solution 4: Utiliser un script SQL

### Créer le fichier SQL

Créez un fichier `setup-mysql.sql` avec ce contenu:

```sql
-- Créer la base de données
CREATE DATABASE IF NOT EXISTS evaluation_sn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Utiliser la base de données
USE evaluation_sn;

-- Accorder tous les privilèges
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'root'@'localhost';
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'root'@'127.0.0.1';
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'root'@'%';

-- Recharger les privilèges
FLUSH PRIVILEGES;
```

### Exécuter via phpMyAdmin

1. Ouvrez phpMyAdmin
2. Cliquez sur l'onglet **"SQL"**
3. Copiez-collez le contenu du fichier
4. Cliquez sur **"Exécuter"**

---

## 🔍 Vérifier la configuration

### Vérifier que MySQL fonctionne

```bash
php artisan tinker
```

Puis dans tinker:
```php
DB::connection()->getPdo();
// Si ça fonctionne, vous verrez: PDO object
```

### Vérifier les tables

Après migration:
```bash
php artisan tinker
```

```php
DB::table('users')->count();
DB::table('abonnes')->count();
DB::table('factures')->count();
```

---

## 📊 Voir la base de données dans phpMyAdmin

Une fois les migrations réussies:

1. Ouvrez `http://localhost/phpmyadmin`
2. Cliquez sur **"evaluation_sn"** dans la liste à gauche
3. Vous verrez toutes vos tables:
   - users
   - abonnes
   - factures
   - personal_access_tokens
   - migrations
   - cache
   - jobs
   - etc.

---

## 🧪 Tester l'API avec MySQL

```bash
# Lancer les tests
php artisan test

# Lancer le serveur
php artisan serve

# Tester l'API
http://127.0.0.1:8000/test-auth.html
```

---

## ⚠️ Problèmes courants

### Erreur: "Access denied for user 'root'@'localhost'"

**Solution**: Le mot de passe root n'est pas vide. Vérifiez dans phpMyAdmin ou créez un nouvel utilisateur.

### Erreur: "SQLSTATE[HY000] [2002] No connection could be made"

**Solution**: MySQL n'est pas démarré. Vérifiez que WampServer est en vert et que MySQL est actif.

### Erreur: "Base table or view already exists"

**Solution**: 
```bash
php artisan migrate:fresh --seed
```

### Les données ne s'affichent pas dans phpMyAdmin

**Solution**: Actualisez la page (F5) ou cliquez sur le nom de la base de données.

---

## 📝 Configuration finale

Votre fichier `.env` devrait ressembler à:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evaluation_sn
DB_USERNAME=root
DB_PASSWORD=
```

Ou avec le nouvel utilisateur:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=evaluation_sn
DB_USERNAME=laravel
DB_PASSWORD=laravel123
```

---

## ✅ Checklist

- [ ] WampServer est démarré (icône verte)
- [ ] MySQL est actif
- [ ] Base de données `evaluation_sn` créée
- [ ] Privilèges accordés à l'utilisateur
- [ ] Fichier `.env` configuré
- [ ] `php artisan config:clear` exécuté
- [ ] `php artisan migrate:fresh --seed` réussi
- [ ] Tables visibles dans phpMyAdmin
- [ ] Tests passent: `php artisan test`

---

**Une fois terminé, vous verrez toutes vos tables dans phpMyAdmin!** 🎉
