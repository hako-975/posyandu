<?php 

require_once '../includes/DbOperations.php';
$response = array();

$db = new DbOperations();
$result = $db->getAntrian();

while($row = $result->fetch_assoc())
{
    $temp = array();
    $temp['no_antrian'] = $row['no_antrian'];
    $temp['nama_lengkap'] = $row['nama_lengkap'];
    $temp['status_antrian'] = $row['status_antrian'];
    $temp['nik'] = $row['nik'];
    array_push($response, $temp);
}
 
echo json_encode($response);