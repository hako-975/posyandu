<?php 

require_once 'connection.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['nik']) && isset($_POST['nama_lengkap']) && isset($_POST['password'])) {
		// kode 0 nik sudah terdaftar
		// kode 1 berhasil
		// kode 2 gagal
		// kode 3 input harus diisi

		if ($_POST['nik'] == '' OR $_POST['nama_lengkap'] == '' OR $_POST['password'] == '') {
			$response['error'] = true;
			$response['message'] = "Semua input harus diisi";
			$response['kode'] = 3;
		} else {
			$result = createUser($_POST['nik'], $_POST['nama_lengkap'], $_POST['password']);
			if ($result == 1) {
				$response['error'] = false;
				$response['message'] = "Registrasi berhasil";
				$response['kode'] = 1;
			} elseif ($result == 2) {
				$response['error'] = true;
				$response['message'] = "Registrasi gagal";
				$response['kode'] = 2;
			} elseif ($result == 0) {
				$response['error'] = true;
				$response['message'] = "NIK Anda sudah terdaftar";
				$response['kode'] = 0;
			}
		}
	} else {
		$response['error'] = true;
		$response['message'] = "Semua input harus diisi";
		$response['kode'] = 3;
	}
} else {
	$response['error'] = true;
	$response['message'] = "Invalid Request";
}

echo json_encode($response);

?>