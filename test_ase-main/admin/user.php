<?php include('view/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">User
                <!-- Button trigger modal Tambah-->
                <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#tambahUser">
                    Tambah User
                </button>

                <!-- Modal Tambah-->
                <div class="modal fade" id="tambahUser" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Tambah User</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="code.php" method="POST">
                                    <div class="col-md-12 mb-3">
                                        <label for="id">ID</label>
                                        <input type="text" id="id" name="id" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="username">Username</label>
                                        <input type="text" id="username" name="username" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" id="password" name="password" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" id="name" name="name" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="role">role</label>
                                        <select class="form-control" name="role" id="role">
                                            <option value="">Choose your role</option>
                                            <option value="admin">Admin</option>
                                            <option value="anggota">Anggota</option>
                                            <option value="dosen">Dosen</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="saveUser">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </h4>
        </div>
        <div class="card-body">
            <?php alertMessage(); ?>
            <?php
            $user = getAll('user');
            if (!$user) {
                echo '<h4>Something Went Wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($user) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>name</th>
                                <th>role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($user as $userItem) : ?>
                                <tr>
                                    <td><?= $userItem['id'] ?></td>
                                    <td><?= $userItem['username'] ?></td>
                                    <td><?= $userItem['name'] ?></td>
                                    <td><?= $userItem['role'] ?></td>
                                    <td>
                                        <!-- Button trigger modal Edit-->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUser<?= $userItem['id'] ?>">
                                            Edit
                                        </button>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editUser<?= $userItem['id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalLabel">Tambah Admin</h1>
                                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="code.php" method="POST">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="id">ID</label>
                                                                <input type="text" id="id" name="id" required class="form-control" value="<?= $userItem['id'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="username">Username</label>
                                                                <input type="text" id="username" name="username" required class="form-control" value="<?= $userItem['username'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="password">Password</label>
                                                                <input type="password" id="password" name="password" required class="form-control" value="<?= $userItem['password'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="name">Name</label>
                                                                <input type="text" id="name" name="name" required class="form-control" value="<?= $userItem['name'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="role">role</label>
                                                                <select class="form-control" name="role" id="role">
                                                                    <option value="">Choose your Faculty</option>
                                                                    <option value="admin" <?php if ($userItem['role'] == "admin") echo "selected" ?>>Admin</option>
                                                                    <option value="anggota" <?php if ($userItem['role'] == "anggota") echo "selected" ?>>Anggota</option>
                                                                    <option value="dosen" <?php if ($userItem['role'] == "dosen") echo "selected" ?>>Dosen</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="updateUser">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUser<?= $userItem['id'] ?>">
                                            Delete
                                        </button>
                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteUser<?= $userItem['id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalLabel">Delete User</h1>
                                                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="code.php" method="POST">
                                                            <div class="col-md-12 mb-3">
                                                                <label>Yakin untuk menghapus data?</label>
                                                            </div>
                                                            <input type="hidden" value="<?= $userItem['id'] ?>" name="id" id="id" class="form-control">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-warning" data-dismiss="modal">NO</button>
                                                                <button type="submit" class="btn btn-danger" name="deleteUser">YES</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>
                </div>
            <?php
            } else {
            ?>
                <tr>
                    <h4 class="mb-0">No Record Found</td>
                </tr>
            <?php
            }
            ?>
        </div>
    </div>
</div>


<?php include('view/footer.php') ?>