<?php
session_start();

require_once "Database.php";

if ($_GET["id"]) {
    $id = $_GET["id"];
    $sql = "DELETE FROM user WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg"] = "Delete Student Data Is Successfull...";
        header("location:ViewStudentAdmin.php");
        exit();
    }
}

?>