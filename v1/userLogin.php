<?php 

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['nik']) && isset($_POST['password'])) {
		$db = new DbOperations();

		if ($db->userLogin($_POST['nik'], $_POST['password'])) {
			$user = $db->getUserByNik($_POST['nik']);
			$response['error'] = false;
			$response['nik'] = $user['nik'];
			$response['nama_lengkap'] = $user['nama_lengkap'];
			$response['role'] = $user['role'];
		} else {
			$response['error'] = true;
			$response['message'] = "NIK atau Password yang Anda masukkan salah";	
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Semua input harus diisi";
		$response['kode'] = 3;
	}
}

echo json_encode($response);