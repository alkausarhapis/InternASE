<?php include('view/header.php') ?>

<div class="container-fluid px-4">
    <div class="card mt-4 shadow">
        <div class="card-header">
            <h4 class="mb-0">Admin
                <!-- Button trigger modal Tambah-->
                <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#tambahAdmin">
                    Tambah Admin
                </button>

                <!-- Modal Tambah-->
                <div class="modal fade" id="tambahAdmin" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Tambah Admin</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="code.php" method="POST">
                                    <div class="col-md-12 mb-3">
                                        <label for="nim">NIM</label>
                                        <input type="text" id="nim" name="nim" required class="form-control">
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
                                        <label for="nama">Nama</label>
                                        <input type="text" id="nama" name="nama" required class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="saveAdmin">Save</button>
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
            $admins = getAll('admins');
            if (!$admins) {
                echo '<h4>Something Went Wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($admins) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($admins as $adminItem) : ?>
                                <tr>
                                    <td><?= $adminItem['nim'] ?></td>
                                    <td><?= $adminItem['nama'] ?></td>
                                    <td><?= $adminItem['username'] ?></td>
                                    <td>
                                        <!-- Button trigger modal Edit-->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editAdmin<?= $adminItem['nim'] ?>">
                                            Edit
                                        </button>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editAdmin<?= $adminItem['nim'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalLabel">Tambah Admin</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="code.php" method="POST">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="nim">NIM</label>
                                                                <input type="text" id="nim" name="nim" required class="form-control" value="<?= $adminItem['nim'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="username">Username</label>
                                                                <input type="text" id="username" name="username" required class="form-control" value="<?= $adminItem['username'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="password">Password</label>
                                                                <input type="password" id="password" name="password" required class="form-control" value="<?= $adminItem['password'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="nama">Nama</label>
                                                                <input type="text" id="nama" name="nama" required class="form-control" value="<?= $adminItem['nama'] ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="updateAdmin">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteAdmin<?= $adminItem['nim'] ?>">
                                            Delete
                                        </button>
                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteAdmin<?= $adminItem['nim'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalLabel">Delete Admin</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="code.php" method="POST">
                                                            <div class="col-md-12 mb-3">
                                                                <label >Yakin untuk menghapus data?</label>
                                                            </div>
                                                            <input type="hidden" value="<?= $adminItem['nim']?>" name="nim" id="nim" class="form-control">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">NO</button>
                                                                <button type="submit" class="btn btn-danger" name="deleteAdmin">YES</button>
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