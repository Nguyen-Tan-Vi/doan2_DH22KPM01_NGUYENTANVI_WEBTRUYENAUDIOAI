<?php
require_once '../../check_admin.php'; 
require_once '../../../includes/db.php'; 

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM chapter WHERE id = '$id'");
header('Location: index.php');
?>