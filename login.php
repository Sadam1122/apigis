<?php
include ("inc_koneksi.php");
session_start();
$err = ""; // Inisialisasi variabel $err

if(isset($_SESSION["admin_username"])){
    header("location: admin.php");
}

if(isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username =='' or $password ==''){
        $err ="<li>Masukan Username dan Password yang Benar !</li>";
    }
    if (empty($err)){
        $sql1 = "select *from admin where username = '$username' ";
        $q1 = mysqli_query ($db,$sql1);
        $r1 = mysqli_fetch_array($q1);
        if($r1['password'] != md5($password)){
            $err ="<li>Akun tidak ditemukan</li>";
        }
    }
    if (empty($err)){
        $login_id = $r1['login_id'];
        $sql1 = "select *from admin_akses where login_id = '$login_id' ";
        $q1 = mysqli_query ($db,$sql1);
        while($r1=mysqli_fetch_array($q1)){
            $akses[] = $r1['akses_id'];
        }
        if (empty($akses)){
            $err = "<li>Tidak Memiliki Akses</li>";
        }
    }
    if (empty($err)){ 
        $_SESSION['admin_username'] = $username;
        $_SESSION['admin_akses'] = $akses;
        header("location: admin.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Super Admin -SIKAT Bandung</title>
</head>
<body>
    <div id="app">
    <h1>LOGIN</h1>
    <h2>Silahkan masuk dengan akun Anda</h2>
    <?php
    if ($err){
        echo "<ul>$err</ul>";
    }
    ?>
        <form action="" method="POST"><br/><br/>
            <label for="username">Masukkan Username</label>
            <input type="text" placeholder="username" name="username" /><br/><br/>
            <label for="password">Masukkan Password</label>
            <input type="password" placeholder="password" name="password" /><br/><br/>
            <button type="submit" name="login">Masuk</button>
        </form>
</body>
</html>
