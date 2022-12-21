<?php
//untuk ranking sites
include("../config.php"); //include konfigurasi database
if(isset($_POST["linkId"])){//jika link di klik
    $query = $con->prepare("UPDATE sites SET clicks = clicks + 1 WHERE id = :id "); //query untuk update nilai click, untuk setiap klik, nilai akan ditambah 1
    $query->bindParam(":id", $_POST["linkId"]);
    $query->execute();//eksekusi
}else{
    echo "no link passed to page";
}