<?php
$koneksi = mysqli_connect('localhost', 'root', '', 'platform');

function tambahAkun($data) {
    global $koneksi;
    $username = $data['nama'];
    $password1 = mysqli_real_escape_string($koneksi, $data['password1']);
    $password2 = mysqli_real_escape_string($koneksi, $data['password2']);

    if (!empty($username) && (!empty($password1) || !empty($password2))) {
        if ($password1 != $password2) {
            return "Password Berbeda";
        } else {
            $existing_user = jalankanQuery("SELECT * FROM user WHERE username='$username'");
            if (!$existing_user) {
                $password1 = password_hash($password1, PASSWORD_DEFAULT);
                $query = "INSERT INTO user (username, password) VALUES ('$username', '$password1')";
                mysqli_query($koneksi, $query);
                return "success";
            } else {
                return "Nama pengguna sudah digunakan, mohon pilih yang lain";
            }
        }
    } else {
        return "Semua kolom wajib diisi";
    }
}

function tambahTodo($data) {
    global $koneksi;
    $text = $data['todo'];
    $user_id = $_SESSION["user_id"];

    $query = "INSERT INTO todo (todolist, status, user_id) VALUES ('$text', 'onprocess',$user_id)";
    mysqli_query($koneksi, $query);
}

function jalankanQuery() {
    global $koneksi;
    $result = mysqli_query($koneksi, "SELECT id FROM user");
    
    if ($result) {
        $userIds = [];
        
        while ($row = mysqli_fetch_assoc($result)) {
            $userIds[] = $row['id'];
        }
        
        // Buat string untuk kondisi WHERE dalam query SQL
        $userIdsString = implode(',', $userIds); // Menggabungkan id pengguna menjadi string
        
        // Gunakan string id pengguna dalam query untuk mendapatkan tugas yang sesuai
        $query = "SELECT * FROM todo WHERE user_id IN ($userIdsString)";
        
        $resultTodo = mysqli_query($koneksi, $query);
        
        if ($resultTodo) {
            $datasRecords = [];
            
            while ($rowTodo = mysqli_fetch_assoc($resultTodo)) {
                $datasRecords[] = $rowTodo;
            }
            
            return $datasRecords;
        } else {
            return null;
        }
    } else {
        return null;
    }
}

foreach ($_POST as $key => $value) {
    if (strpos($key, 'hapus') !== false) {
        $index = substr($key, strlen('hapus'));
        hapusData($_POST, $index);
    }
}

function hapusData($data, $index) {
    global $koneksi;
    $isi = $data['isi' . $index];
    $query = "SELECT status FROM todo WHERE todolist = '$isi'";
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row && isset($row['status']) && $row['status'] == 'selesai') {
            $deleteQuery = "DELETE FROM todo WHERE todolist = '$isi'";
            mysqli_query($koneksi, $deleteQuery);
            return "Data berhasil dihapus";
        } else {
            $confirm = true;
            if ($confirm) {
                $deleteQuery = "DELETE FROM todo WHERE todolist = '$isi'";
                mysqli_query($koneksi, $deleteQuery);
                return "Data berhasil dihapus";
            }
        }
    } else {
        return "Ada kesalahan saat mengambil status data";
    }
}

function tandaiSelesai($data, $index) {
    global $koneksi;
    $isi = $data['isi' . $index];
    $query = "UPDATE todo SET status = 'selesai' WHERE todolist = '$isi'";
    mysqli_query($koneksi, $query);
    return "Tugas telah ditandai sebagai selesai";
}
?>