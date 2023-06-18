<?php 

require_once '../includes/DbOperations.php';
$response = array();

$db = new DbOperations();
$result = $db->getAntrian();

while ($row = $result->fetch_assoc()) {
    $item = array(
        'no_antrian' => $row['no_antrian'],
        'nik' => $row['nik'],
        'status_antrian' => $row['status_antrian']
    );
    $response[] = $item;
}

echo json_encode($response);