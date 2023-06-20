<?php 
	
	class DbOperations {
		private $con;

		function __construct() {
			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();
		}

// USER ---------------------------------------------------------------
		public function createUser($nik, $nama_lengkap, $password)
		{
			if ($this->isUserExist($nik)) {
				return 0;				
			} else {
				$password = md5($password);
				$stmt = $this->con->prepare("INSERT INTO `user` (`nik`, `nama_lengkap`, `password`, `role`) VALUES (?, ?, ?, 'Pelanggan');");
				$stmt->bind_param("sss", $nik, $nama_lengkap, $password);

				if ($stmt->execute()) {
					return 1;
				} else {
					return 2;
				}
			}
		}

		public function userLogin($nik, $password)
		{
			$password = md5($password);
			$stmt = $this->con->prepare("SELECT * FROM `user` WHERE `nik` = ? && `password` = ?");
			$stmt->bind_param("ss", $nik, $password);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

		public function getUserByNik($nik) 
		{
			$stmt = $this->con->prepare("SELECT * FROM `user` WHERE `nik` = ?");
			$stmt->bind_param("s", $nik);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}

		private function isUserExist($nik)
		{
			$stmt = $this->con->prepare("SELECT `nik` FROM `user` WHERE `nik` = ?");
			$stmt->bind_param("s", $nik);
			$stmt->execute();
			$stmt->store_result();
			return $stmt->num_rows > 0;
		}

// ANTRIAN ---------------------------------------------------------------
		public function getAntrian()
		{
			$stmt = $this->con->prepare("SELECT * FROM `antrian` INNER JOIN `user` ON `antrian`.`nik` = `user`.`nik` ORDER BY `no_antrian`");
			$stmt->execute();
			return $stmt->get_result();
		}

		public function getHasAntrianByNik($nik) 
		{
		    $stmt = $this->con->prepare("SELECT * FROM `antrian` WHERE `nik` = ? AND status_antrian = 'Pending'");
		    $stmt->bind_param("s", $nik);
		    $stmt->execute();
		    return $stmt->get_result()->fetch_assoc();
		}


		public function createAntrian($nik) 
		{
		    // Check if there is an existing pending antrian
		    $existingAntrian = $this->getHasAntrianByNik($nik);
		    if ($existingAntrian) {
		        return array(
		            'status' => 0,
		            'message' => "Anda sudah mengambil No. Antrian: " . $existingAntrian['no_antrian']
		        );
		    }
		    
		    // Get the maximum existing no_antrian
    		$maxNoAntrian = $this->getMaxNoAntrian();
    		$newNoAntrian = $maxNoAntrian + 1;

		    $stmt = $this->con->prepare("INSERT INTO `antrian` (`no_antrian`, `nik`, `status_antrian`) VALUES ($newNoAntrian, ?, 'Pending');");
		    $stmt->bind_param("s", $nik);
		    
		    if ($stmt->execute()) {
		        $newAntrianId = $stmt->insert_id;
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

		private function getMaxNoAntrian()
		{
		    $stmt = $this->con->prepare("SELECT MAX(`no_antrian`) AS max_no_antrian FROM `antrian`");
		    $stmt->execute();
		    $result = $stmt->get_result();
		    $row = $result->fetch_assoc();
		    
		    return $row['max_no_antrian'] ?? 0;
		}
		
		public function batalkanAntrian($no_antrian) 
		{
		    $stmt = $this->con->prepare("UPDATE `antrian` SET `status_antrian` = 'Dibatalkan' WHERE `no_antrian` = ?");
		    $stmt->bind_param("s", $no_antrian);
		    
		    if ($stmt->execute()) {
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

		public function selesaikanAntrian($no_antrian) 
		{
		    $stmt = $this->con->prepare("UPDATE `antrian` SET `status_antrian` = 'Selesai' WHERE `no_antrian` = ?");
		    $stmt->bind_param("s", $no_antrian);
		    
		    if ($stmt->execute()) {
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

		public function pendingkanAntrian($no_antrian) 
		{
		    $stmt = $this->con->prepare("UPDATE `antrian` SET `status_antrian` = 'Pending' WHERE `no_antrian` = ?");
		    $stmt->bind_param("s", $no_antrian);
		    
		    if ($stmt->execute()) {
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

		public function deleteAllAntrian()
		{
			$stmt = $this->con->prepare("DELETE FROM `antrian`");
		    if ($stmt->execute()) {
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
	}

?>