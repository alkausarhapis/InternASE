<?php 
    include('view/header.php'); 

    if (isset($_SESSION['loggedIn'])) {
        ?>
        <script>window.location.href = 'admin/index.php'</script>
        <?php
    }
?>
    <div class="container mt-5" >
        <div class="header"></div>
        <div class="login-form card shadow-sm p-4 mt-5">
            <img src="logo.jpeg" alt="Advanced Software Engineering Laboratory" class="logo mx-auto d-block">
            <h2>Admin Login</h2>
            <form action="login-code.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="username" id="username" placeholder="User name" class="form-control mb-3" require>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" id="password" placeholder="Password" class="form-control mb-3" require>
                </div>
                <div class="mb-3">
                    <button type="submit" name="loginBtnAdm" class="btn btn-primary btn-block login-button">Login</button>
                </div>
            </form>
        </div>
    </div>
<?php include('view/footer.php'); ?>