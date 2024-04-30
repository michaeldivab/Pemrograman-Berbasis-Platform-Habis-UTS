<?php
// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'platform');

// Fungsi untuk menambahkan akun baru
function tambahAkun($data) {
    global $koneksi;
    $username = $data['nama'];
    $password1 = mysqli_real_escape_string($koneksi, $data['password1']);
    $password2 = mysqli_real_escape_string($koneksi, $data['password2']);

    // Validasi input
    if (!empty($username) && !empty($password1) && !empty($password2)) {
        if ($password1 != $password2) {
            return "Password tidak sama";
        } else {
            // Periksa apakah username sudah digunakan
            $existing_user = jalankanQuery("SELECT * FROM user WHERE username='$username'");
            if (!$existing_user) {
                $hashed_password = password_hash($password1, PASSWORD_DEFAULT);
                $query = "INSERT INTO user (username, password) VALUES ('$username', '$hashed_password')";
                mysqli_query($koneksi, $query);
                return "success";
            } else {
                return "Nama pengguna sudah digunakan, silakan pilih yang lain";
            }
        }
    } else {
        return "Semua kolom wajib diisi";
    }
}

// Fungsi untuk menambahkan todo baru
function tambahTodo($data) {
    global $koneksi;
    if (isset($_SESSION["user_id"])) {
        $text = mysqli_real_escape_string($koneksi, $data['todo']);
        $user_id = $_SESSION["user_id"];
        $query = "INSERT INTO todo (todolist, status, user_id) VALUES ('$text', 'onprocess', $user_id)";
        mysqli_query($koneksi, $query);
    } else {
        return "User ID tidak tersedia";
    }
}

// Fungsi untuk menjalankan query dan mengembalikan hasil
function jalankanQuery($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        $datasRecords = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $datasRecords[] = $row;
        }
        return $datasRecords;
    } else {
        return null;
    }
}

// Fungsi untuk menghapus data todo
function hapusData($data, $index) {
    global $koneksi;
    $isi = mysqli_real_escape_string($koneksi, $data['isi' . $index]);
    $query = "DELETE FROM todo WHERE todolist = '$isi'";
    mysqli_query($koneksi, $query);
    return "Data berhasil dihapus";
}

// Fungsi untuk menandai tugas sebagai selesai
function tandaiSelesai($data, $index) {
    global $koneksi;
    $isi = mysqli_real_escape_string($koneksi, $data['isi' . $index]);
    $query = "UPDATE todo SET status = 'selesai' WHERE todolist = '$isi'";
    mysqli_query($koneksi, $query);
    return "Tugas telah ditandai sebagai selesai";
}
?>
