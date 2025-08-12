<?php
error_reporting(0);
session_start();

require_once "Database.php";

if (isset($_POST["apply"])) {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $mobileno = $_POST["number"];

    $checkData = "SELECT * FROM admission WHERE name='" . $name . "' OR email='" . $email . "'";
    $checkResult = mysqli_query($conn, $checkData);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION["msg"] = "This Student Is Already applied...";
        header("location:Index.php");
        exit();
    }

    $checkData1 = "SELECT * FROM user WHERE name='" . $name . "' OR email='" . $email . "'";
    $checkResult1 = mysqli_query($conn, $checkData1);

    if (mysqli_num_rows($checkResult1) > 0) {
        $_SESSION["msg"] = "Your Admission Is Confirm...";
        header("location:Index.php");
        exit();
    }


    $sql = "INSERT INTO admission(name, email, password, mobileno) VALUES('$name', '$email', '$password', '$mobileno')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION["msg"] = "Applied Successfull...";
        header("location:Index.php");

    } else {
        $_SESSION["msg"] = "Applied Failed...";
        header("location:Index.php");
    }
    exit();
}
?>