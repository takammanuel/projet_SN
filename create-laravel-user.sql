-- Script pour créer un utilisateur Laravel dédié
-- À exécuter dans phpMyAdmin ou la console MySQL

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS evaluation_sn CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer l'utilisateur Laravel (si n'existe pas)
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY 'laravel123';
CREATE USER IF NOT EXISTS 'laravel'@'127.0.0.1' IDENTIFIED BY 'laravel123';
CREATE USER IF NOT EXISTS 'laravel'@'%' IDENTIFIED BY 'laravel123';

-- Accorder tous les privilèges sur la base evaluation_sn
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'laravel'@'localhost';
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'laravel'@'127.0.0.1';
GRANT ALL PRIVILEGES ON evaluation_sn.* TO 'laravel'@'%';

-- Recharger les privilèges
FLUSH PRIVILEGES;

-- Afficher un message de confirmation
SELECT 'Utilisateur Laravel créé avec succès!' AS Message;
SELECT 'Utilisateur: laravel' AS Info1;
SELECT 'Mot de passe: laravel123' AS Info2;
SELECT 'Base de données: evaluation_sn' AS Info3;
