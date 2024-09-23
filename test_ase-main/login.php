<?php 
    include('view/header.php'); 

    if (isset($_SESSION['loggedIn'])) {
        ?>
        <script>window.location.href = 'admin/index.php'</script>
        <?php
    }

?>
    

    <div class="py-5" bgb-light>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-sm p-4 mt-5">
                        <?php alertMessage(); ?>
                        <div class="p-5">
                            <h4 class="text-dark mb-3">Sign into your ASE Account</h4>
                            <form action="login-code.php" method="POST">

                                <div class="mb-3">
                                    <label for="">Enter Username</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="">Enter Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="my-3">
                                    <button type="submit" name="loginBtn" class="btn btn-primary w-100 mt-2">Sign In</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include('view/footer.php'); ?>