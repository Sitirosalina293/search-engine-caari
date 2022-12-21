<?php
//untuk menampilkan single gambar
include("../config.php"); //menyambungkan dengan database
if(isset($_POST["src"])){ //jika ada gambar yang di klik
    $query = $con->prepare("UPDATE images SET broken = 1 WHERE imageUrl = :imageUrl "); //query untuk update nilai broken 
    $query->bindParam(":imageUrl", $_POST["src"]); //deklarasi :imageUrl yang merupakan $_POST ["src"] atau url gambar
    $query->execute(); //eksekusi
}else{
    echo "no image passed to page";
}