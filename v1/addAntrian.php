<?php 

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['nik'])) {
		// kode 0 nik sudah ada antrian pending
		// kode 1 berhasil
		// kode 2 gagal

		$db = new DbOperations();
		
		$result = $db->createAntrian($_POST['nik']);
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
	}
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);

?>