<?php 
	
	class DbOperations {
		private $con;

		function __construct() {
			require_once dirname(__FILE__).'/DbConnect.php';

			$db = new DbConnect();

			$this->con = $db->connect();
		}

		// CRUD -> Create
		function createUser($nik, $nama_lengkap, $password)
		{
			$password = md5($password);
			$stmt = $this->con->prepare("INSERT INTO `user` (`nik`, `nama_lengkap`, `password`, `role`) VALUES (?, ?, ?, 'Pelanggan');");
			$stmt->bind_param("sss", $nik, $nama_lengkap, $password);

			if ($stmt->execute()) {
				return true;
			} else {
				return false;
			}
		}
	}
?>