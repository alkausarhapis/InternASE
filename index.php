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
        <?php alertMessage(); ?>
        <div class="login-form card shadow-sm p-4 mt-5">
            <img src="logo.jpeg" alt="Advanced Software Engineering Laboratory" class="logo mx-auto d-block">
            <div class="d-flex justify-content-around">
                <a href="admin-login.php" class="btn btn-outline-primary">ADMIN</a>
                <a href="mahasiswa-login.php" class="btn btn-outline-primary">MAHASISWA</a>
                <a href="dosen-login.php" class="btn btn-outline-primary">DOSEN</a>
            </div>
        </div>
    </div>

<?php include('view/footer.php'); ?>