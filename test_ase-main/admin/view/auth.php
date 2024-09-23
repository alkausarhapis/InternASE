<?php

if (isset($_SESSION['loggedIn'])) {
    $uid = validate($_SESSION['loggedInUser']['id']);
    $username = validate($_SESSION['loggedInUser']['username']);
    $role = validate($_SESSION['loggedInUser']['role']);

    $query = "SELECT * FROM user WHERE id = '$uid' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0 && $role != 'admin'){
        logoutSession();
        redirect('../login', 'Access Denied!');
    } else {
        $row = mysqli_fetch_assoc($result);
    }

} else {
    redirect('../index.php', 'Login to continue...');
}

?>