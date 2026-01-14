<?php
use App\Repository\DataBaseGarage;

require dirname(__DIR__).'/vendor/autoload.php';

$pdo = DataBaseGarage::connection();

$sqlFilePath = __DIR__.'/initTable.sql';


    $sqlContent = file_get_contents($sqlFilePath);

    $result = $pdo->exec($sqlContent);

    if ($result === false) {
        echo "Erreur d'exécution : " . print_r($pdo->errorInfo(), true);
    } else {
        echo "Exécution réussie!\n";
    }
    $pdo = null;
