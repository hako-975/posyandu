<?php 
	
	class DbOperations {
		private $con;

		function __construct() {
			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();
		}

		// CRUD -> Create
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

		public function getAntrian()
		{
			$stmt = $this->con->prepare("SELECT * FROM `antrian` ORDER BY `no_antrian`");
			$stmt->execute();
			return $stmt->get_result();
		}

		public function getHasAntrianByNik($nik) 
		{
			$stmt = $this->con->prepare("SELECT * FROM `antrian` WHERE `nik` = ? && status_antrian = 'Pending'");
			$stmt->bind_param("s", $nik);
			$stmt->execute();
			return $stmt->get_result()->fetch_assoc();
		}
	}
?>