<?php include('view/header.php') ?>

<div class="container-fluid px-4">
    <div class="card shadow">
        <div class="card-header">
            <h4 class="mb-0">Data Anggota
                <!-- Button trigger modal Tambah-->
                <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#tambahAnggota">
                    Tambah Anggota
                </button>

                <!-- Modal Tambah-->
                <div class="modal fade" id="tambahAnggota" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Tambah Anggota</h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="col-md-12 mb-3">
                                        <label for="nim">NIM</label>
                                        <input type="text" id="nim" name="nim" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="fullname">Name</label>
                                        <input type="text" id="fullname" name="fullname" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="age">Age</label>
                                        <input type="number" id="age" name="age" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="faculty">Faculty</label>
                                        <select class="form-control" name="faculty" id="faculty">
                                            <option value="">Choose your Faculty</option>
                                            <option value="FIF">FIF</option>
                                            <option value="FIK">FIK</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="major">Major</label>
                                        <input type="text" id="major" name="major" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="entry_year">Entry year</label>
                                        <input type="number" id="entry_year" name="entry_year" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="picture">Picture</label>
                                        <input type="file" id="picture" name="picture" class="form-control">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="saveMembers">Save</button>
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
            $members = getAll('members');
            if (!$members) {
                echo '<h4>Something Went Wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($members) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Name</th>
                                <th>Faculty</th>
                                <th>Major</th>
                                <th>Entry year</th>
                                <th>Age</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($members as $membersItem) : ?>
                                <tr>
                                    <td><?= $membersItem['nim'] ?></td>
                                    <td>
                                        <img src="../<?= $membersItem['picture']; ?>" alt="gk ada gambar" style="width:50px; height:50px; border-radius: 50%; margin-right:10px;">
                                        <?= $membersItem['fullname'] ?>
                                    </td>
                                    <td><?= $membersItem['faculty'] ?></td>
                                    <td><?= $membersItem['major'] ?></td>
                                    <td><?= $membersItem['entry_year'] ?></td>
                                    <td><?= $membersItem['age'] ?></td>
                                    <td>
                                        <!-- Button trigger modal Edit-->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAnggota<?= $membersItem['nim'] ?>">
                                            Edit
                                        </button>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editAnggota<?= $membersItem['nim'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalLabel">Edit Barang</h1>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="code.php" method="POST" enctype="multipart/form-data">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="nim">NIM</label>
                                                                <input type="text" id="nim" name="nim" required class="form-control" value="<?= $membersItem['nim'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="fullname">Name</label>
                                                                <input type="text" id="fullname" name="fullname" required class="form-control" value="<?= $membersItem['fullname'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="age">Age</label>
                                                                <input type="number" id="age" name="age" required class="form-control" value="<?= $membersItem['age'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="faculty">Faculty</label>
                                                                <select class="form-control" name="faculty" id="faculty">
                                                                    <option value="">Choose your Faculty</option>
                                                                    <option value="FIF" <?php if ($membersItem['faculty'] == "FIF") echo "selected" ?>>FIF</option>
                                                                    <option value="FIK" <?php if ($membersItem['faculty'] == "FIK") echo "selected" ?>>FIK</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="major">Major</label>
                                                                <input type="text" id="major" name="major" required class="form-control" value="<?= $membersItem['major'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="entry_year">Entry Year</label>
                                                                <input type="number" id="entry_year" name="entry_year" required class="form-control" value="<?= $membersItem['entry_year'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="picture">Gambar</label>
                                                                <input type="file" id="picture" name="picture" class="form-control">
                                                                <img src="../<?= $membersItem['picture']; ?>" alt="gambar" style="width:50px; height:50px;">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="updateMembers">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAnggota<?= $membersItem['nim'] ?>">
                                            Delete
                                        </button>
                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteAnggota<?= $membersItem['nim'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="modalLabel">Delete Barang</h1>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="code.php" method="POST">
                                                            <div class="col-md-12 mb-3">
                                                                <label>Yakin untuk menghapus data?</label>
                                                            </div>
                                                            <input type="hidden" value="<?= $membersItem['nim'] ?>" name="nim" id="nim" class="form-control">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-warning" data-bs-dismiss="modal">NO</button>
                                                                <button type="submit" class="btn btn-danger" name="deleteMembers">YES</button>
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