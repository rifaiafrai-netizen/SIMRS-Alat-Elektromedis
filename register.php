<?php
session_start();
include_once("config.php");

$error = "";

if (isset($_POST['register'])) {

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if ($username == "" || $password == "") {
        $error = "Username dan password harus diisi!";
    } else {

        $cek = mysqli_prepare($mysqli, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($cek, "s", $username);
        mysqli_stmt_execute($cek);
        mysqli_stmt_store_result($cek);

        if (mysqli_stmt_num_rows($cek) > 0) {
            $error = "Username sudah digunakan!";
        } else {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = mysqli_prepare(
                $mysqli,
                "INSERT INTO users (username, password) VALUES (?, ?)"
            );

            mysqli_stmt_bind_param($stmt, "ss", $username, $hash);

            if (mysqli_stmt_execute($stmt)) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Registrasi gagal!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register SIMRS</title>

    <style>
        body {
            background: #f1f5f9;
            font-family: Arial;
        }

        .container {
            width: 350px;
            margin: 100px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #142d4e;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body>

<div class="container">

    <h2>Register SIMRS</h2>

    <?php if ($error != "") echo "<p style='color:red'>$error</p>"; ?>

    <form method="POST">

        <input type="text" name="username"
               placeholder="Username" required>

        <input type="password" name="password"
               placeholder="Password" required>

        <button type="submit" name="register">
            Daftar
        </button>

    </form>

    <p>Sudah punya akun?
        <a href="login.php">Login</a>
    </p>

</div>

</body>
</html>