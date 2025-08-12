<?php
session_start();

require_once "Database.php";

if ($_GET["id"]) {
    $id = $_GET["id"];
    $sql = "DELETE FROM course WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg"] = "Delete Course Data Is Successfull...";
        header("location:ViewCourseAdmin.php");
        exit();
    }
}

?>