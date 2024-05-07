<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit(); 
}
require 'koneksi.php';
$error ='';

// Memanggil jalankanQuery() dengan query SQL yang sesuai
$user_id = $_SESSION["user_id"];
$tasks = jalankanQuery("SELECT * FROM todo WHERE user_id = $user_id");

// Proses jika tombol "Tambah" ditekan
if (isset($_POST['tambah'])){
    if (!empty($_POST['todo'])){
        tambahTodo($_POST);
        // Redirect kembali ke halaman todoList setelah menambah tugas
        header("Location: todoList.php");
        exit();
    } else {
        echo "<script> 
              alert('Data Harus Diisi');
              </script>";
    }
}

// Periksa setiap elemen $_POST untuk menangani tombol "Selesai" atau "Hapus"
foreach ($_POST as $key => $value) {
    if (strpos($key, 'selesai_') !== false) {
        $index = substr($key, strlen('selesai_'));
        tandaiSelesai($_POST, $index);
        // Setelah menandai selesai, perbarui daftar tugas
        $tasks = jalankanQuery("SELECT * FROM todo WHERE user_id = $user_id");
    } elseif (strpos($key, 'hapus_') !== false) {
        $index = substr($key, strlen('hapus_'));
        hapusData($_POST, $index);
        // Setelah menghapus, perbarui daftar tugas
        $tasks = jalankanQuery("SELECT * FROM todo WHERE user_id = $user_id");
    }
}
?>

<!-- HTML dan JavaScript -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <style>
        /* CSS untuk mencoret teks */
        .coret {
            text-decoration: line-through;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        h2 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: 70%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-right: 10px;
        }

        input[type="submit"] {
            padding: 8px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        del {
            color: #999;
        }

        a {
            text-decoration: none;
            color: #333;
            padding: 3px 8px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-left: 5px;
        }

        a:hover {
            background-color: #f4f4f4;
        }

    </style>
</head>
<body>
    <header>
    <h1>Michael Diva Berliano</h1>
        <img src="logotugas.png" alt="Foto Profil">
        <h2>225314020</h2>

        <!-- Tombol logout -->
        <form action="logout.php" method="post">
            <button type="submit" name="logout" value="1">Logout</button>
        </form>
    </header>
    <form action="" method="post">
        <div class="container">
            <!-- Form untuk menambah tugas -->
            <div class="tambah-todo">
                <input type="text" name="todo" placeholder="Teks todo">
                <button class="tambah" name="tambah">Tambah</button>
            </div>
            
            <!-- Daftar tugas -->
            <?php foreach ($tasks as $index => $task):?>
                <div class="show-todo">
                    <!-- Input field untuk tugas -->
                    <input type="text" name="isi<?php echo $index;?>" value="<?php echo $task['todolist']; ?>" class="<?php echo $task['status'] === 'selesai' ? 'coret' : '';?>">
                    
                    <!-- Tombol "Selesai" -->
                    <button class="tambah" name="selesai_<?php echo $index; ?>" onclick="toggleCoret(this)">Selesai</button>
                    
                    <!-- Tombol "Hapus" -->
                    <button class="tambah" name="hapus_<?php echo $index; ?>">Hapus</button>
                </div>
            <?php endforeach;?>
        </div>
    </form>

    <!-- Script JavaScript -->
    <script>
        function toggleCoret(button) {
            var inputField = button.previousElementSibling; // Dapatkan input field sebelum tombol
            inputField.classList.toggle('coret'); // Tambah atau hilangkan kelas 'coret'
        }
    </script>
</body>
</html>
