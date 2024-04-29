<?php
require 'koneksi.php';

session_start();

if (!isset($_SESSION["regis"])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submitbtn'])) {
    $result = tambahAkun($_POST); // Call the tambahAkun function
    if ($result === "success") {
        header("Location: login.php"); // Redirect to login page after successful registration
        exit();
    }
    // Handle the result (error message) accordingly
    echo "<script>alert('$result');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Your CSS styles -->
</head>
<body>
    <!-- Your HTML content -->
    <form action="" method="post">
        <div class="container">
            <h2>Register</h2>
            <div class="grup">
                <label for="name">Nama</label>
                <input type="text" name="nama" placeholder="Nama">
            </div>
            <div class="grup">
                <label for="password1">Password</label>
                <input type="password" name="password1" placeholder="Password">
            </div>
            <div class="grup">
                <label for="password2">Ulangi Password</label>
                <input type="password" name="password2" placeholder="Ulangi Password">
            </div>
            <button type="submit" class="submitbtn" name="submitbtn">Submit</button>
        </div>
    </form>
</body>
</html>
