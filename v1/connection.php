<?php 
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db   = 'posyandu';
	$conn = mysqli_connect($host, $user, $pass, $db);

	if ($conn) {
		// echo "berhasil";
	}

	function createUser($nik, $nama_lengkap, $password)
	{
		global $conn;

	    if (isUserExist($nik)) {
	        return 0;
	    } else {
	        $password = md5($password);
	        $query = "INSERT INTO `user` (`nik`, `nama_lengkap`, `password`, `role`) VALUES ('$nik', '$nama_lengkap', '$password', 'Pelanggan');";

	        if (mysqli_query($conn, $query)) {
	            return 1;
	        } else {
	            return 2;
	        }
	    }
	}

	function userLogin($nik, $password)
	{
		global $conn;

	    $password = md5($password);
	    $query = "SELECT * FROM `user` WHERE `nik` = '$nik' AND `password` = '$password';";
	    $result = mysqli_query($conn, $query);

	    return mysqli_num_rows($result) > 0;
	}

	function getUserByNik($nik)
	{
		global $conn;
	    $query = "SELECT * FROM `user` WHERE `nik` = '$nik';";
	    $result = mysqli_query($conn, $query);

	    return mysqli_fetch_assoc($result);
	}

	function isUserExist($nik)
	{
		global $conn;
	    $query = "SELECT `nik` FROM `user` WHERE `nik` = '$nik';";
	    $result = mysqli_query($conn, $query);

	    return mysqli_num_rows($result) > 0;
	}

	function getAntrian() {
	    global $conn;
	    $response = array();
	    $antrian = mysqli_query($conn, "SELECT * FROM `antrian` INNER JOIN `user` ON `antrian`.`nik` = `user`.`nik` ORDER BY `no_antrian`");

	    foreach ($antrian as $dataAntrian) {
	        $temp = array();
	        $temp['no_antrian'] = $dataAntrian['no_antrian'];
	        $temp['nama_lengkap'] = $dataAntrian['nama_lengkap'];
	        $temp['status_antrian'] = $dataAntrian['status_antrian'];
	        $temp['nik'] = $dataAntrian['nik'];
	        array_push($response, $temp);
	    }

	    return $response;
	}

	function getHasAntrianByNik($nik) {
	    global $conn;
	    $query = "SELECT * FROM `antrian` WHERE `nik` = '$nik' AND `status_antrian` = 'Pending'";
	    $result = mysqli_query($conn, $query);
	    return mysqli_fetch_assoc($result);
	}

	function getMaxNoAntrian() {
	    global $conn;
	    $query = "SELECT MAX(`no_antrian`) AS max_no_antrian FROM `antrian`";
	    $result = mysqli_query($conn, $query);
	    $row = mysqli_fetch_assoc($result);
	    
	    return $row['max_no_antrian'] ?? 0;
	}

	function createAntrian($nik)
	{
		global $conn;
	    $existingAntrian = getHasAntrianByNik($nik);
	    if ($existingAntrian) {
	        return array(
	            'status' => 0,
	            'message' => "Anda sudah mengambil No. Antrian: " . $existingAntrian['no_antrian']
	        );
	    }

	    $maxNoAntrian = getMaxNoAntrian();
	    $newNoAntrian = $maxNoAntrian + 1;

	    $query = "INSERT INTO `antrian` (`no_antrian`, `nik`, `status_antrian`) VALUES ($newNoAntrian, '$nik', 'Pending');";

	    if (mysqli_query($conn, $query)) {
	        $newAntrianId = mysqli_insert_id($conn);
	        return array(
	            'status' => 1,
	            'message' => "Berhasil! No. Antrian: " . $newAntrianId
	        );
	    } else {
	        return array(
	            'status' => 2,
	            'message' => "Gagal membuat No. Antrian"
	        );
	    }
	}

	function batalkanAntrian($no_antrian)
	{
		global $conn;
	    $query = "UPDATE `antrian` SET `status_antrian` = 'Dibatalkan' WHERE `no_antrian` = '$no_antrian';";

	    if (mysqli_query($conn, $query)) {
	        return array(
	            'status' => 1,
	            'message' => "No. Antrian: " . $no_antrian . " Berhasil dibatalkan"
	        );
	    } else {
	        return array(
	            'status' => 2,
	            'message' => "Gagal membatalkan No. Antrian: " . $no_antrian
	        );
	    }
	}

	function selesaikanAntrian($no_antrian)
	{
		global $conn;
	    $query = "UPDATE `antrian` SET `status_antrian` = 'Selesai' WHERE `no_antrian` = '$no_antrian';";

	    if (mysqli_query($conn, $query)) {
	        return array(
	            'status' => 1,
	            'message' => "No. Antrian: " . $no_antrian . " Berhasil diselesaikan"
	        );
	    } else {
	        return array(
	            'status' => 2,
	            'message' => "Gagal membatalkan No. Antrian: " . $no_antrian
	        );
	    }
	}

	function pendingkanAntrian($no_antrian)
	{
		global $conn;
	    $query = "UPDATE `antrian` SET `status_antrian` = 'Pending' WHERE `no_antrian` = '$no_antrian';";

	    if (mysqli_query($conn, $query)) {
	        return array(
	            'status' => 1,
	            'message' => "No. Antrian: " . $no_antrian . " Berhasil dipendingkan"
	        );
	    } else {
	        return array(
	            'status' => 2,
	            'message' => "Gagal mem-pendingkan No. Antrian: " . $no_antrian
	        );
	    }
	}

	function deleteAllAntrian()
	{
		global $conn;
	    $query = "DELETE FROM `antrian`;";

	    if (mysqli_query($conn, $query)) {
	        return array(
	            'status' => 1,
	            'message' => "Semua Antrian Berhasil Terhapus"
	        );
	    } else {
	        return array(
	            'status' => 2,
	            'message' => "Gagal menghapus Antrian"
	        );
	    }
	}
