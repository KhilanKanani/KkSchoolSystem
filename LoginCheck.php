<?php
session_start();
error_reporting(0);

require_once "Database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM user where email='" . $email . "' AND password='" . $password . "'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);

    if ($row["usertype"] == "admin") {
        $_SESSION["email"] = $email;
        $_SESSION["usertype"] = "admin";
        header("location:Admin.php");

    } else if ($row["usertype"] == "student") {
        $_SESSION["email"] = $email;
        $_SESSION["usertype"] = "student";
        header("location:Student.php");

    } else {
        $msg = "Username And Password Not Match...";
        $_SESSION["LoginMessage"] = $msg;
        header("location:Login.php");
    }
}

?>