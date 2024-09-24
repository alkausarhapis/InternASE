<?php include('view/header.php') ?>

<h1 class="main-title">Document</h1>
<div class="search-bar">
    <input type="text" id="searchInput" placeholder="Search...">
    <button onclick="searchTable()">Search</button>
</div>

<div class="table-container">
    <?php alertMessage(); ?>
    <?php
    $document = getAll('document');
    if (!$document) {
        echo '<h4>Something Went Wrong! </h4>';
        return false;
    }

    if (mysqli_num_rows($document) > 0) {

    ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Borrower</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($document as $documentItem) : ?>
                        <tr>
                            <td>
                                <strong><?= $documentItem['tittle'] ?></strong><br>
                                <small><?= $documentItem['author'] ?></small>
                            </td>
                            <td><?= $documentItem['status'] ?></td>
                            <td>
                                <button class="borrow-button btn btn-primary" data-toggle="modal" data-target="#borrowModal">Borrow</button>
                                <button class="icon-button"><i class="fa fa-trash" data-toggle="modal" data-target="#deleteModal"></i></button>
                                <button class="icon-button"><i class="fa fa-ellipsis-h"></i></button>
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

<button class="new-doc-button btn btn-primary" data-toggle="modal" data-target="#newDocModal">New Document</button>

<!-- Modal New Document -->
<div class="modal fade" id="newDocModal" tabindex="-1" aria-labelledby="newDocModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newDocModalLabel">New Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="code.php" method="POST">
                    <div class="form-group">
                        <label for="tittle">Title</label>
                        <input type="text" class="form-control" id="tittle" name="tittle" placeholder="Enter title" required>
                    </div>
                    <div class="form-group">
                        <label for="borrow">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">Choose Status Borrow</option>
                            <option value="available">Available</option>
                            <option value="borrowed">Borrowed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" class="form-control" id="author" name="author" placeholder="Enter Author name" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="addDocument">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- masukkan button modal footer ke form ; button untuk save change dan semacamnya jadi submit  -->

<!-- Modal Borrow -->
<div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #FF6F00;">
                <h5 class="modal-title" id="borrowModalLabel" style="color: white;">Borrow</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center mb-3">
                    <i class="fa fa-book" style="font-size: 24px; margin-right: 10px;"></i>
                    <div>
                        <strong id="borrowModalTitle"><?= $documentItem['tittle'] ?></strong><br>
                        <small id="borrowModalAuthor"><?= $documentItem['author'] ?></small>
                    </div>
                </div>
                <hr>
                <form action="code.php" method="POST">
                    <div class="form-group">
                        <input type="hidden" value="<?= $documentItem['id'] ?>" name="idDocument" id="idDocument" class="form-control">
                        <input type="hidden" value="<?= $user['id'] ?>" name="idUser" id="idUser" class="form-control">
                        <label for="returnTime">Return Time</label>
                        <input type="date" class="form-control datepicker" name="returnTime" id="returnTime" placeholder="Select return date">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="borrowDocument">Confirm</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php include('view/footer.php') ?>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Delete Document</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color: white;">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="code.php" method="POST">
                    <div class="col-md-12 mb-3">
                        <label>Yakin untuk menghapus data?</label>
                    </div>
                    <input type="hidden" value="<?= $documentItem['id'] ?>" name="id" id="id" class="form-control">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">NO</button>
                        <button type="submit" class="btn btn-danger" name="deleteDocument">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</html>