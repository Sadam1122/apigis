<?php
include("layout/header.php");
if(!in_array("co-admin", $_SESSION['admin_akses'])){
    echo "Kamu Tidak Punya Akses";
    include("layout/footer.php");
    exit();
}


// Memproses form penambahan pengguna baru
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $akses_id = $_POST['akses_id'];  // Menggunakan akses_id dari form
    
    // Enkripsi password
    $password_hashed = md5($password);
    
    // Cek apakah username sudah ada
    $sql_check = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($db, $sql_check);
    
    if (mysqli_num_rows($result) > 0) {
        $message = "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Masukkan data ke tabel admin dengan waktu pembuatan otomatis
        $sql = "INSERT INTO admin (username, password) VALUES ('$username', '$password_hashed')";
        if (mysqli_query($db, $sql)) {
            $login_id = mysqli_insert_id($db);  // Ambil login_id dari admin yang baru saja dibuat
            
            // Masukkan data ke tabel admin_akses
            $sql_access = "INSERT INTO admin_akses (login_id, akses_id) VALUES ('$login_id', '$akses_id')";
            if (mysqli_query($db, $sql_access)) {
                $message = "Akun berhasil dibuat!";
            } else {
                $message = "Error saat menambahkan akses: " . mysqli_error($db);
            }
        } else {
            $message = "Error: " . mysqli_error($db);
        }
    }
}

// Memproses penghapusan pengguna
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Hapus dari tabel admin_akses terlebih dahulu untuk menjaga integritas referensial
    $sql_delete_access = "DELETE FROM admin_akses WHERE login_id = '$delete_id'";
    mysqli_query($db, $sql_delete_access);
    
    // Kemudian hapus dari tabel admin
    $sql_delete = "DELETE FROM admin WHERE login_id = '$delete_id'";
    if (mysqli_query($db, $sql_delete)) {
        $message = "Akun berhasil dihapus!";
    } else {
        $message = "Error: " . mysqli_error($db);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    color: #333;
}
/* Container Styles */
.container {
    max-width: 1200px;
    display: flex;
    justify-content: flex-start;
    align-items: flex-start;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    
}

/* Heading Styles */
h3 {
    color: #444;
    margin-bottom: 20px;
    text-align: center;
}
h1 {
    color: #444;
    margin-bottom: 20px;
    text-align: center;
}
h4 {
    color: #818181;
    margin-bottom: 15px;
    text-align: left;
    font-style: normal;
}
/* Form Styles */
form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 10px;
}

form label {
    font-weight: bold;
    margin: auto;
    text-align: left;
    width: 100%;
    max-width: 400px;
}

form input, form select {
    padding: 10px;
    width: 100%;
    max-width: 400px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px;
    font-size: 1rem;
}

form button {
    padding: 10px 20px;
    background-color: #095caa;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1rem;
    width: 100%;
    max-width: 400px;
}

/*Sidebar*/ 
.sidebar {
    width: 250px;
    background-color: #f4f4f4;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.sidebar h3 {
    margin-bottom: 20px;
    color: #333;
    position: left;
    font-style: bold;
}

.menu .btn {
    display: block;
    padding: 10px;
    margin-bottom: 10px;
    background-color: #F5842E;
    color: white;
    text-align: center;
    text-decoration: none;
    border-radius: 4px;
    cursor: pointer;
}

.menu .btn.active {
    background-color: #C25807;
}
.menu .btn:hover {
    background-color: #F2A163;
}
/*delete button*/
.delete-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #B11116;
    border-radius: 5px;
    text-align: center;
    cursor: pointer;
}

.delete-button a {
    color: white;
    text-decoration: none;
}

.delete-button:hover {
    background-color: #ED1C24;
}
.main-content {
    flex-grow: 1;
    padding: 25px;
    background-color: #fff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

.main-content h2 {
    margin-bottom: 20px;
}
/**/
form button:hover {
    background-color: #095caa;
}

/* Table Styles */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
}

table th {
    background-color: #095caa;
    color: white;
    font-weight: bold;
}

table td a {
    color: #e74c3c;
    text-decoration: none;
    font-weight: bold;
}

table td a:hover {
    color: #c0392b;
}

@media (max-width: 768px) {
    table th, table td {
        padding: 8px;
        font-size: 0.9rem;
    }
}

/* Notification Styles */
p {
    text-align: center;
    color: #ffff;
    font-weight: bold;
    margin: 10px 0;
}

/* Responsive Design */
@media (max-width: 600px) {
    .container {
        padding: 15px;
    }

    form input, form select, form button {
        width: 90%;
    }

    table {
        font-size: 0.8rem;
    }
}

    </style>
</head>
<body>


<!-- Pesan Notifikasi -->
<?php if (isset($message)) { echo "<p>$message</p>"; } ?>


<div class="container">
        <div class="sidebar">
            <h3>Menu</h3>
            <div class="menu">
                <a href="#" class="btn" onclick="showContent('addacc')">Tambah Akun</a>
                <a href="#" class="btn" onclick="showContent('listacc')">Daftar Pengguna</a>
            </div>
        </div>

        <div class="main-content">
            <div id="account" class="content">
                <h1>Co-Admin</h1>
                <h4>Selamat datang di Menu Co-Admin.Pilih menu di sebelah kiri untuk mengakses fitur-fitur pengelolaan akun. <br> Klik 'Tambah Akun' untuk menambah pengguna baru,
                    atau klik 'Daftar Pengguna' untuk melihat daftar pengguna yang sudah ada.</h4>
            </div>
        <!-- Form Tambah Akun -->
        <div id="addacc" class="content" style="display: none;">
            <h2>Tambah Akun</h2>
        <form action="admin.php" method="POST">
            <label>Username:</label><br/>
            <input type="text" name="username" required><br/><br/>    
            <label>Password:</label><br/>
            <input type="password" name="password" required><br/><br/>
            <label>Jenis Akses:</label><br/>
            <select name="akses_id" required>
            <option value="staff">Staff</option>
            </select><br/><br/>
            <button type="submit">Tambah Akun</button>
        </form>
        </div>

        <div id="listacc" class="content" style="display: none;">
                <h2>Daftar Pengguna</h2>
                <table border="1">
                    <tr>
                        <th>Username</th>
                        <th>Akses</th>
                        <th>Waktu Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                    <?php
                // Menampilkan daftar pengguna
                $sql_users = "SELECT admin.login_id, admin.username, admin_akses.akses_id, admin.created_at 
                            FROM admin 
                            JOIN admin_akses ON admin.login_id = admin_akses.login_id
                            WHERE admin_akses.akses_id = 'staff'";  // Filter untuk hanya menampilkan role staff
                $result_users = mysqli_query($db, $sql_users);

                while ($row = mysqli_fetch_assoc($result_users)) {
                    echo "<tr>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['akses_id'] . "</td>";
                    echo "<td>" . $row['created_at'] . "</td>";  // Menampilkan waktu pembuatan
                    echo "<td>";
                    echo "<div class='delete-button'>
                            <a href='admin.php?delete_id=" . $row['login_id'] . "' 
                            onclick=\"return confirm('Yakin ingin menghapus akun ini?');\">Hapus</a>
                        </div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
                </table>
        </div>
    </div>
    <script>
        function showContent(section) {
            // Hide all content sections
            var contents = document.getElementsByClassName('content');
            for (var i = 0; i < contents.length; i++) {
                contents[i].style.display = 'none';
            }

            // Show the selected section
            document.getElementById(section).style.display = 'block';

            // Update the active menu item
            var menuItems = document.getElementsByClassName('btn');
            for (var i = 0; i < menuItems.length; i++) {
                menuItems[i].classList.remove('active');
            }
            event.currentTarget.classList.add('active');
        }
    </script>

<!-- Tabel Pengguna 
<h4>Daftar Pengguna</h4>
<table border="1">
    <tr>
        <th>Username</th>
        <th>Akses</th>
        <th>Waktu Dibuat</th>
        <th>Aksi</th>
    </tr>
    <?php
// Menampilkan daftar pengguna
$sql_users = "SELECT admin.login_id, admin.username, admin_akses.akses_id, admin.created_at 
              FROM admin 
              JOIN admin_akses ON admin.login_id = admin_akses.login_id
              WHERE admin_akses.akses_id = 'staff'";  // Filter untuk hanya menampilkan role staff
$result_users = mysqli_query($db, $sql_users);

while ($row = mysqli_fetch_assoc($result_users)) {
    echo "<tr>";
    echo "<td>" . $row['username'] . "</td>";
    echo "<td>" . $row['akses_id'] . "</td>";
    echo "<td>" . $row['created_at'] . "</td>";  // Menampilkan waktu pembuatan
    echo "<td>";
    echo "<a href='admin.php?delete_id=" . $row['login_id'] . "' onclick=\"return confirm('Yakin ingin menghapus akun ini?');\">Hapus</a>";
    echo "</td>";
    echo "</tr>";
}
?>
</table>
-->
<?php
include("layout/footer.php");
?>



    <footer>
        <p>All rights reserved &copy; 2024, Create By : DAM</p>
    </footer>
</body>
</html>

