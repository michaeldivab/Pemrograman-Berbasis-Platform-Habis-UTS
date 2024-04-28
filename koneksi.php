<?php 
    $conn = mysqli_connect('localhost','root','','platform');
    function tambahAkun($data){
        global $conn;
        $username = $data['nama'];
        $password1 = mysqli_real_escape_string($conn,$data['password1']);
        $password2 = mysqli_real_escape_string($conn,$data['password2']);

        if($username != null && ($password1 != null || $password2 != null)){
            if($password1 != $password2){
                echo'<script> alert("password beda");</script>';
            } else {
                $existing_user = query("SELECT * FROM user WHERE username='$username'");
                if(!$existing_user){
                    $password1 = password_hash($password1,PASSWORD_DEFAULT);
                    $query ="INSERT INTO user (username, password) VALUES ('$username', '$password1')";
                    mysqli_query($conn,$query);
                    header("Location: login.php");
                    exit();
                } else {
                    echo'<script> alert("username udah dipakai harap ganti");</script>';
                }
            }
        } else {
            echo'<script> alert("semua wajib diisi");</script>';
        }
    }

    function tambahTodo($data){
        global $conn;
        $text = $data['todo'];
        $user_id = $_SESSION["user_id"]; // Ambil user_id dari sesi
    
        $query = "INSERT INTO todo (todo, status, user_id) VALUES ('$text', 'onprocess', '$user_id')"; // Sertakan kolom 'status' dan 'user_id' dalam perintah INSERT INTO
    
        mysqli_query($conn,$query);
    }
    
    function query($query){
        global $conn;
        $hasil = mysqli_query($conn,$query);
        $datas = [];
        while ($row = mysqli_fetch_assoc($hasil)){
            $datas[] = $row;
        }
        return $datas;
    }

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'hapus') !== false) {
            $index = substr($key, strlen('hapus')); 
            hapus($_POST, $index);
        }
    }
    
    function hapus($data, $index){
        global $conn;
        $isi = $data['isi'.$index];
        $query = "SELECT status FROM todo WHERE todo = '$isi'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if ($row && isset($row['status']) && $row['status'] == 'selesai') {
                // Jika status 'selesai', hapus saja tanpa konfirmasi
                $deleteQuery = "DELETE FROM todo WHERE todo = '$isi'";
                mysqli_query($conn, $deleteQuery);
                echo "<script>alert('Data berhasil dihapus');</script>";
            } else {
                // Jika status 'onprocess', minta konfirmasi
                $confirm = true; // Atur ke true atau false berdasarkan logika Anda
                if ($confirm) {
                    $deleteQuery = "DELETE FROM todo WHERE todo = '$isi'";
                    mysqli_query($conn, $deleteQuery);
                    echo "<script>alert('Data berhasil dihapus');</script>";
                }
            }
        } else {
            echo "<script>alert('Terjadi kesalahan dalam mengambil status data');</script>";
        }
    }    
    
    function selesai($data,$index){
        global $conn;
        $isi = $data['isi'.$index];
        $query = "UPDATE todo SET status = 'selesai' WHERE todo = '$isi'";
        mysqli_query($conn,$query);
    
        // Simpan status 'selesai' ke dalam database
        $updateStatusQuery = "UPDATE todo SET status = 'selesai' WHERE todo = '$isi'";
        mysqli_query($conn, $updateStatusQuery);
    
        return 'selesai';
    }    
?>