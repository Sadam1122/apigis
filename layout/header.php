<?php
include("inc_koneksi.php");
session_start();
if(!isset($_SESSION['admin_username'])){
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <style>
/* Base Styles */
body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #003285;
            color: white;
            padding: 7px 20px;
            position: sticky;
            top: 0;
            width: 97.6%;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .logo {
            font-size: 1.86em;
            font-weight: bold;
            margin-left: 15px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding:0;
            display: flex;
            gap: 15px;
        }
        nav ul li {
            margin: 0;
            margin: -1px 10px 0px 11px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1em;
            padding: 8px 12px;
            transition: background-color 0.3s, color 0.3s;
            border-radius: 4px;
        }
        nav ul li a:hover {
            background: #0b71d081;
            color: #ff8121; /* Add a color transition on hover */
        }
/* Settings Page Styles */
.settings-container {
    text-align: center;
    padding: 50px 20px;
    background-color: #ffffff;
    width: 80%;
    max-width: 800px;
    margin: 50px auto;
    border-radius: 8px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.settings-container:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.profile-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 30px;
}

.profile-section img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin-bottom: 15px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.profile-section img:hover {
    transform: scale(1.05);
}

.profile-section h2 {
    font-size: 2em;
    margin: 0;
    color: #095caa;
}

.profile-section p {
    font-size: 1em;
    color: #777;
    margin: 5px 0;
}

.info-section {
    text-align: left;
    margin-bottom: 20px;
}

.info-section h3 {
    font-size: 1.2em;
    margin-bottom: 10px;
    color: #333;
    border-bottom: 2px solid #095caa;
    padding-bottom: 5px;
}

.info-section p {
    font-size: 1em;
    margin: 5px 0;
    color: #555;
}

.logout-btn {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 25px;
    background-color: #d9534f;
    color: white;
    text-align: center;
    text-decoration: none;
    font-size: 1em;
    border-radius: 5px;
    transition: background-color 0.3s ease, transform 0.3s ease;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.logout-btn:hover {
    background-color: #c9302c;
    transform: translateY(-3px);
}

/* Footer Styles */
footer {
    text-align: center;
    margin-top: 50px;
    padding: 20px;
    background-color: #303030;
    color: white;
    font-size: 1em;
}

/* Responsive Design */
@media (max-width: 768px) {
    nav ul {
        flex-direction: column;
        gap: 10px;
    }
    .settings-container {
        width: 90%;
    }
    .profile-section img {
        width: 100px;
        height: 100px;
    }
    .profile-section h2 {
        font-size: 1.5em;
    }
    .info-section {
        text-align: center;
    }
}

@media (max-width: 480px) {
    header {
        padding: 10px;
    }
    .logo {
        font-size: 1.2em;
    }
    nav ul {
        gap: 8px;
    }
    .settings-container {
        width: 95%;
    }
    .profile-section img {
        width: 80px;
        height: 80px;
    }
    .profile-section h2 {
        font-size: 1.3em;
    }
    .profile-section p {
        font-size: 0.9em;
    }
    .info-section {
        text-align: center;
    }
}
    </style>
</head>
<body>

    <header>
        <div class="logo"><i>SIKAT</i> Bandung</div></li>
        <nav>
            <ul>
                <?php if (in_array("admin", $_SESSION['admin_akses'])){ ?>
                    <li><a href="admin.php">Halaman Admin</a></li>
                <?php } ?>
                <?php if (in_array("co-admin", $_SESSION['admin_akses'])){ ?>
                    <li><a href="co_admin.php">Co-Admin</a></li>
                <?php } ?>
                <li><a href="staff.php/">Staff</a></li>
                <li><a href="logout.php">Keluar</a></li>
            </ul>
        </nav>
    </header>

    <div class="settings-container">
        <div class="profile-section">
            <img src="./gambar/sadam.png" alt="Profile Picture">
            <h2>Sadam Al Rasyid</h2>
            <p>sadamalrasyid@gmail.com</p>
        </div>

        <div class="info-section">
            <h3>Account Information</h3>
            <p>Member since: January 2023</p>
            <p>Last login: August 22, 2024</p>
        </div>

        <a href="logout.php" class="logout-btn">Logout</a>
    </div>

    <!-- <footer>
        <p>All rights reserved &copy; 2024, Create By : DAM</p>
    </footer> -->

</body>
</html>
