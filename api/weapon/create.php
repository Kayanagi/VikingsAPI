<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('create')) {
    returnError(405, 'Method not allowed');
    return;
}

$data = getBody();

if (!validateMandatoryParams($data, ['type', 'damage'])) {
    returnError(400, 'Missing parameters : type, damage');
}

if (!is_string($data['type']) || !is_numeric($data['damage'])) {
    returnError(400, 'Invalid parameters : type must be a string, damage must be a number');
}

$weaponId = createWeapon($data['type'], intval($data['damage']));
if (!$weaponId) {
    returnError(500, 'Could not create weapon');
}

$weapon = findOneWeapon($weaponId);
echo json_encode($weapon);
