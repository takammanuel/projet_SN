<?php

/**
 * Script pour corriger les permissions MySQL
 */

$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'evaluation_sn';

try {
    // Connexion en tant que root
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "🔧 Correction des permissions MySQL...\n\n";
    
    // Accorder tous les privilèges sur la base de données
    $sql = "GRANT ALL PRIVILEGES ON `$database`.* TO 'root'@'localhost'";
    $pdo->exec($sql);
    echo "✅ Privilèges accordés à root@localhost\n";
    
    $sql = "GRANT ALL PRIVILEGES ON `$database`.* TO 'root'@'127.0.0.1'";
    $pdo->exec($sql);
    echo "✅ Privilèges accordés à root@127.0.0.1\n";
    
    $sql = "GRANT ALL PRIVILEGES ON `$database`.* TO 'root'@'%'";
    $pdo->exec($sql);
    echo "✅ Privilèges accordés à root@%\n";
    
    // Recharger les privilèges
    $pdo->exec("FLUSH PRIVILEGES");
    echo "✅ Privilèges rechargés\n\n";
    
    echo "🎉 Permissions corrigées avec succès!\n";
    echo "📝 Vous pouvez maintenant lancer: php artisan migrate:fresh --seed\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "\n";
    echo "💡 Solution alternative:\n";
    echo "1. Ouvrez phpMyAdmin (http://localhost/phpmyadmin)\n";
    echo "2. Allez dans l'onglet 'Comptes utilisateurs'\n";
    echo "3. Modifiez l'utilisateur 'root'\n";
    echo "4. Cochez 'Tout cocher' pour les privilèges globaux\n";
    echo "5. Cliquez sur 'Exécuter'\n";
    exit(1);
}
