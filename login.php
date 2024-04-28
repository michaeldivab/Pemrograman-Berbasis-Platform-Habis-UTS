<?php 
    session_start();
    require 'koneksi.php';
    
    if (isset($_POST['regiss'])) {
        $_SESSION["regis"] = true;
        header("Location: register.php");
        exit();
    } elseif(isset($_POST['loginbtn'])){
        login($_POST);
    }
    

    function login($data){
        global $conn;
        $x = '';
        $username = $data['username'];
        $password = $data['password'];

        $result = mysqli_query($conn,"SELECT * FROM user WHERE Username = '$username'");

        if(mysqli_num_rows($result) == 0){
            echo "<script>
                     alert('Username tidak ditemukan. Pastikan Anda memasukkan username dengan benar');
                  </script>";
        } else {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($password,$row["password"])) {
                $_SESSION["login"] = true;
                header("Location: todoList.php");
                exit();
            } else {
                echo "<script>
                     alert('Password Salah');
                  </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
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

        .regis {
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            width: calc(100% - 8px);
            padding: 10px;
            margin-bottom: 10px;
        }

        .regis:hover {
            background-color: #45a049;
        }

        .register-link {
            text-align: center;
            font-size: 14px;
            margin-top: 10px;
        }

        .register-link a {
            color: #333;
            text-decoration: none;
        }

        .login-btn {
    width: 100%;
    background-color: #4CAF50; /* Warna latar belakang */
    color: #fff; /* Warna teks */
    border: none;
    cursor: pointer;
    padding: 12px 20px; /* Padding tombol */
    border-radius: 5px; /* Sudut melengkung */
    font-size: 16px; /* Ukuran teks */
    font-weight: bold; /* Ketebalan teks */
    transition: background-color 0.3s ease; /* Animasi perubahan warna saat hover */
}

.login-btn:hover {
    background-color: #45a049; /* Warna latar belakang saat hover */
}

    </style>
</head>
<body>
    <div class="profile">
        <img src="logotugas.png" alt="Profile Picture">
        <h3>Michael Diva Berliano</h3>
        <p>225314020</p>
    </div>
    <form action="" method="post">
        <div class="container">
            <h2>Login</h2>
            <div class="grup">
                <label for="username"> Username </label>
                <input type="text" id="username" name="username" placeholder="Username">
            </div>
            <div class="grup">
                <label for="password"> password </label>
                <input type="password" id="password" name="password" placeholder="Password">
            </div>
            <button type="submit" class="login-btn" name="loginbtn">Login</button>
            <div class="register-link">
                <span>Belum punya akun? </span><a href="register.php">Register</a>
        </div>
        </div>
    </form>
</body>
</html>
