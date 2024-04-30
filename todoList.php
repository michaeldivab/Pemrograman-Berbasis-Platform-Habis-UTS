<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit(); 
}
require 'koneksi.php';
$error ='';

// Inisialisasi array status selesai
$completedTasks = [];

// Memanggil jalankanQuery() dengan query SQL yang sesuai
$user_id = $_SESSION["user_id"];
$tasks = jalankanQuery("SELECT * FROM todo WHERE user_id = $user_id");

if (isset($_POST['tambah'])){
    if (!empty($_POST['todo'])){
        tambahTodo($_POST);
        header("Location: todoList.php");
        exit();
    } else {
        echo "<script> 
              alert('Data Harus Diisi');
              </script>";
    }
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'hapus') !== false) {
        $index = substr($key, strlen('hapus')); 
        hapusData($_POST, $index); // Memanggil fungsi hapusData() untuk menghapus tugas
    }
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'selesai') !== false) {
        $index = substr($key, strlen('selesai')); 
        // Simpan informasi tentang todo mana yang selesai dicoret
        $completedTasks[$index] = true; // Simpan indeks tugas yang selesai
        tandaiSelesai($_POST, $index);
    }
}
?>

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
            <div class="tambah-todo">
                <input type="text" name="todo" placeholder="Teks todo">
                <button class="tambah" name="tambah">Tambah</button>
            </div>
            <?php foreach ($tasks as $index => $task):?>
                <div class="show-todo">
                    <!-- Tambahkan kelas 'coret' jika statusnya 'selesai' -->
                    <input type="text" name="isi<?php echo $index;?>" value="<?php echo $task['todolist']; ?>" class="<?php echo $task['status'] === 'selesai' ? 'coret' : '';?>" >
                    <!-- Tambahkan fungsi onClick untuk tombol "Selesai" -->
                    <button class="tambah" name="selesai<?php echo $index;?>" onClick="toggleCoret(this)">Selesai</button>
                    <button class="tambah" name="hapus<?php echo $index;?>">Hapus</button>
                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                </div>
            <?php endforeach;?>

        </div>
    </form>
    <script>
        // Fungsi untuk menambah atau menghilangkan kelas 'coret' saat tombol "Selesai" ditekan
        function toggleCoret(button) {
            var inputField = button.previousElementSibling; // Dapatkan input field sebelum tombol
            inputField.classList.toggle('coret'); // Tambah atau hilangkan kelas 'coret'
        }
    </script>
</body>
</html>
