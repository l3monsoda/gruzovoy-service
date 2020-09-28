<?php

$db = new PDO('mysql:host=localhost;dbname=truck_service', 'root', '');
$db->exec('SET NAMES UTF8');

if(!empty($_FILES)) {

    $targetDir = "../uploads";
    $targetFile = $targetDir.basename($_FILES['file']['name']);

    if(move_uploaded_file($_FILES['file']['tmp_name'], $targetDir)){ 
    } 
}
