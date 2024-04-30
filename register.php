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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-top: 0;
        }

        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: calc(100% - 16px);
            padding: 10px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 0;
            border-radius: 3px;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }

        .profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile img {
            width: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .profile p {
            margin: 0;
        }

        .profile h3 {
            margin-bottom: 5px;
        }

        .grup {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        .submitbtn {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            padding: 10px 0;
            margin-bottom: 10px;
        }

        .submitbtn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<div class="profile">
        <img src="logotugas.png" alt="Profile Picture">
        <h3>Michael Diva Berliano</h3>
        <p>225314020</p>
    </div>    <form action="" method="post">
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