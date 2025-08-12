<?php
session_start();

require_once "Database.php";

if ($_GET["id"]) {
    $id = $_GET["id"];
    $sql = "DELETE FROM teacher WHERE id= $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg"] = "Delete Teacher Data Is Successfull...";
        header("location:ViewTeacherAdmin.php");
        exit();
    }
}
?>