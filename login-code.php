<?php

require('config/function.php');

if (isset($_POST['loginBtnAdm'])) {
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if ($username !== '' && $password !== '') {
        // Gunakan prepared statement untuk keamanan
        $query = "SELECT * FROM user WHERE username=?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $hashedPassword = $row['password'];


            if (password_verify($password, $hashedPassword)) {
                if ($row['role'] != "admin") {
                    redirect('index.php', 'bukan pengurus.');
                } else {
                    $_SESSION['loggedIn'] = true;
                    $_SESSION['loggedInUser'] = [
                        'id' => $row['id'],
                        'username' => $row['username'],
                        'nama' => $row['nama'],
                        'role' => $row['role'],
                    ];
                    redirect('admin/index.php', 'Logged In Successfully');
                }
            } else {
                redirect('index.php', 'Invalid Password');
            }
        } else {
            redirect('index.php', 'Invalid Username');
        }
    } else {
        // Redirect jika form tidak di-submit dengan benar
        redirect('index.php', 'Unauthorized Access');
    }
}
