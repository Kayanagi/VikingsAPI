<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/dao/weapon.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/api/utils/server.php';

header('Content-Type: application/json');

if (!methodIsAllowed('read')) {
    returnError(405, 'Method not allowed');
    return;
}

$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$weapons = findAllWeapons($limit, $offset);
if (!$weapons) {
    $weapons = [];
}
echo json_encode($weapons);
