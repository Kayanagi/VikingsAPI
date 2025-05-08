<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('update')) {
    returnError(405, 'Method not allowed');
    return;
}

if (!isset($_GET['id'])) {
    returnError(400, 'Missing parameter : id');
}

$data = getBody();

if (!validateMandatoryParams($data, ['weaponId'])) {
    returnError(400, 'Missing parameter : weaponId');
}

if (!is_numeric($data['weaponId'])) {
    returnError(400, 'Invalid parameter : weaponId must be a number');
}

$result = addWeaponToViking($_GET['id'], intval($data['weaponId']));

if (is_array($result) && isset($result['error'])) {
    returnError(404, $result['error']);
}

if (!$result) {
    returnError(500, 'Could not add weapon to viking');
}

$viking = findOneViking($_GET['id']);
echo json_encode($viking);
