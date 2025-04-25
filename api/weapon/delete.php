<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('delete')) {
    returnError(405, 'Method not allowed');
    return;
}

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$weapon = findOneWeapon($_GET['id']);
if (!$weapon) {
    returnError(404, 'Weapon not found');
}

$result = deleteWeapon($_GET['id']);
if (!$result) {
    returnError(500, 'Could not delete weapon');
}

echo json_encode(['message' => 'Weapon deleted successfully']);
