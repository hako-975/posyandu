<?php 

require_once 'connection.php';
$response = array();

$result = deleteAllAntrian();
if ($result['status'] == 1) {
	$response['error'] = false;
	$response['message'] = $result['message'];
	$response['kode'] = $result['status'];
} elseif ($result['status'] == 2) {
	$response['error'] = true;
	$response['message'] = $result['message'];
	$response['kode'] = $result['status'];
} elseif ($result['status'] == 0) {
	$response['error'] = true;
	$response['message'] = $result['message'];
	$response['kode'] = $result['status'];
}

echo json_encode($response);

?>