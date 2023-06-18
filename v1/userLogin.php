<?php 

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['nik']) && isset($_POST['password'])) {
		// kode 1 berhasil
		// kode 2 gagal
		// kode 3 input harus diisi
		
		if ($_POST['nik'] == '' OR $_POST['password'] == '') {
			$response['error'] = true;
			$response['message'] = "Semua input harus diisi";
			$response['kode'] = 3;
		} else {
			$db = new DbOperations();
			if ($db->userLogin($_POST['nik'], $_POST['password'])) {
				$user = $db->getUserByNik($_POST['nik']);
				$response['error'] = false;
				$response['nik'] = $user['nik'];
				$response['nama_lengkap'] = $user['nama_lengkap'];
				$response['role'] = $user['role'];
				$response['kode'] = 1;
			} else {
				$response['error'] = true;
				$response['message'] = "NIK atau Password yang Anda masukkan salah";	
				$response['kode'] = 2;
			}
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Semua input harus diisi";
		$response['kode'] = 3;
	}
}

echo json_encode($response);