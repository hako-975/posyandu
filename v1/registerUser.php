<?php 

require_once '../includes/DbOperations.php';
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['nik']) && isset($_POST['nama_lengkap']) && isset($_POST['password'])) {
		$db = new DbOperations();
		if ($db->createUser($_POST['nik'], $_POST['nama_lengkap'], $_POST['password'])) {
			$response['error'] = false;
			$response['message'] = "Registrasi berhasil";
		} else {
			$response['error'] = true;
			$response['message'] = "Registrasi gagal";
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Semua input harus diisi";
	}
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);

?>