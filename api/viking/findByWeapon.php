<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';

header('Content-Type: application/json');

if (!methodIsAllowed('find')) {
    returnError(405, 'Method not allowed');
    return;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    returnError(400, 'Missing or invalid weapon ID');
    return;
}

$weaponId = (int)$_GET['id'];

// Vérifie si l'arme existe

if (!getWeaponById($weaponId)) {
    returnError(404, 'Weapon not found');
    return;
}

// Récupère tous les vikings avec cette arme
$vikings = getVikingsByWeaponId($weaponId);

$result = [];
foreach ($vikings as $viking) {
    $result[] = [
        'name' => $viking['name'],
        'link' => '/viking/findOne.php?id=' . $viking['id']
    ];
}

echo json_encode($result);
