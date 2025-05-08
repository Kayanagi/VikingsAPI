<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/viking.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('patch')) {
    returnError(405, 'Method not allowed');
    return;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    returnError(400, 'Missing or invalid viking ID');
    return;
}

$vikingId = (int) $_GET['id'];
$data = getBody();

if (!validateMandatoryParams($data, ['weaponId'])) {
    returnError(412, 'Mandatory parameter: weaponId');
    return;
}

$weaponId = (int) $data['weaponId'];

if (!getVikingById($vikingId)) {
    returnError(404, 'Viking not found');
    return;
}

if (!getWeaponById($weaponId)) {
    returnError(404, 'Weapon not found');
    return;
}

if (!addWeaponToViking($vikingId, $weaponId)) {
    returnError(500, 'Failed to assign weapon');
    return;
}

echo json_encode(['message' => 'Weapon successfully assigned to viking']);
