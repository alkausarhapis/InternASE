<?php include('view/header.php') ?>

<div class="container-fluid px-4">
    <div class="card shadow">
        <div class="card-header">
            <h4 class="mb-0">Inventaris
                <!-- Button trigger modal Tambah-->
                <button type="button" class="btn btn-primary float-end" data-toggle="modal" data-target="#tambahBarang">
                    Tambah Barang
                </button>

                <!-- Modal Tambah-->
                <div class="modal fade" id="tambahBarang" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="modalLabel">Tambah Barang</h1>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <div class="col-md-12 mb-3">
                                        <label for="id">ID</label>
                                        <input type="text" id="id" name="id" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="item">Nama Barang</label>
                                        <input type="text" id="item" name="item" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="unit">Unit</label>
                                        <input type="number" id="unit" name="unit" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="date">Tanggal</label>
                                        <input type="date" id="date" name="date" required class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="picture">Picture</label>
                                        <input type="file" id="picture" name="picture" class="form-control">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description">Deskripsi</label>
                                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" name="saveInventory">Save</button>
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
            $inventory = getAll('inventory');
            if (!$inventory) {
                echo '<h4>Something Went Wrong! </h4>';
                return false;
            }
            if (mysqli_num_rows($inventory) > 0) {

            ?>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Barang</th>
                                <th>Unit</th>
                                <th>Tanggal</th>
                                <th>Gambar</th>
                                <th>Deskripsi</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($inventory as $inventoryItem) : ?>
                                <tr>
                                    <td><?= $inventoryItem['id'] ?></td>
                                    <td><?= $inventoryItem['item'] ?></td>
                                    <td><?= $inventoryItem['unit'] ?></td>
                                    <td><?= $inventoryItem['date'] ?></td>
                                    <td>
                                        <img src="../<?=$inventoryItem['picture'];?>" alt="gk ada gambar" style="width:50px; height:50px;">
                                    </td>
                                    <td><?= $inventoryItem['description'] ?></td>
                                    <td>
                                        <!-- Button trigger modal Edit-->
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editInventory<?= $inventoryItem['id'] ?>">
                                            Edit
                                        </button>
                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="editInventory<?= $inventoryItem['id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
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
                                                                <label for="id">ID</label>
                                                                <input type="text" id="id" name="id" required class="form-control" value="<?= $inventoryItem['id'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="item">Nama Barang</label>
                                                                <input type="text" id="item" name="item" required class="form-control" value="<?= $inventoryItem['item'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="unit">Unit</label>
                                                                <input type="number" id="unit" name="unit" required class="form-control" value="<?= $inventoryItem['unit'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="date">Tanggal</label>
                                                                <input type="date" id="date" name="date" required class="form-control" value="<?= $inventoryItem['date'] ?>">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="picture">Gambar</label>
                                                                <input type="file" id="picture" name="picture" class="form-control">
                                                                <img src="../<?=$inventoryItem['picture'];?>" alt="gambar" style="width:50px; height:50px;">
                                                            </div>
                                                            <div class="col-md-12 mb-3">
                                                                <label for="description">Deskripsi</label>
                                                                <input type="text" id="description" name="description" class="form-control" value="<?= $inventoryItem['description'] ?>">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="updateInventory">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteInventory<?= $inventoryItem['id'] ?>">
                                            Delete
                                        </button>
                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="deleteInventory<?= $inventoryItem['id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
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
                                                                <label >Yakin untuk menghapus data?</label>
                                                            </div>
                                                            <input type="hidden" value="<?= $inventoryItem['id']?>" name="id" id="id" class="form-control">
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-warning" data-dismiss="modal">NO</button>
                                                                <button type="submit" class="btn btn-danger" name="deleteInventory">YES</button>
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