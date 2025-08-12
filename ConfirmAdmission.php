<?php
session_start();

require_once "Database.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM admission WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $name = $row["name"];
    $email = $row["email"];
    $password = $row["password"];
    $mobileno = $row["mobileno"];
    $usertype = "student";

    $checkData = "SELECT * FROM user WHERE name='$name' OR email='$email'";
    $checkResult = mysqli_query($conn, $checkData);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION["msg"] = "This Student already exists!";
        header("location:AdmissionAdmin.php");
        exit();
    }

    $sql1 = "INSERT INTO user(name, email, password, mobileno, usertype) 
             VALUES('$name', '$email', '$password', '$mobileno', '$usertype')";
    $result1 = mysqli_query($conn, $sql1);

    $sql2 = "DELETE FROM admission WHERE id = $id";
    $result2 = mysqli_query($conn, $sql2);

    if ($result2) {
        $_SESSION["msg"] = "Admission Confirm...";
        header("location:AdmissionAdmin.php");
        exit();
    }
}
?>