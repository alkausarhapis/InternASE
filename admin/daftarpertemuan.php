<?php include 'view/header.php'?>

<h1 class="main-title">Daftar Pertemuan</h1>
<div class="container mt-3">
    <?php alertMessage();?>
    <?php
$meeting = getAll( 'meeting' );
if ( !$meeting ) {
    echo '<h4>Something Went Wrong! </h4>';
    return false;
}

if ( mysqli_num_rows( $meeting ) > 0 ) {

    ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Speaker</th>
                <th>Date</th>
                <th>Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $meeting as $meetingItem ): ?>
            <tr>
                <td><?=$meetingItem['title']?></td>
                <td><?=$meetingItem['speaker']?></td>
                <td><?=$meetingItem['date']?></td>
                <td><?=$meetingItem['start_time']?> - <?=$meetingItem['end_time']?></td>
                <td class="actions">
                    <a class="icon-button" target="_blank" href="<?=$meetingItem['meeting_link']?>"
                        id="meeting_link"><i class="fa-solid fa-link"></i></button>
                        <button class="icon-button" data-toggle="modal" data-target="#deleteMeeting"><i
                                class="fa fa-trash"></i></button>
                        <button class="icon-button"><i class="fa-solid fa-ellipsis-vertical" data-toggle="modal"
                                data-target="#deleteModal"></i></button>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
    <?php
} else {
    ?>
    <tr>
        <h4 class="mb-0">No Record Found</td>
    </tr>
    <?php
}
?>
    <button class="btn btn-primary" data-toggle="modal" data-target="#addMeetingModal">New Meeting</button>
</div>

<!-- Add Meeting form -->
<div class="modal fade" id="addMeetingModal" tabindex="-1" role="dialog" aria-labelledby="addMeetingModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="meeting">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="popupLabel">New Meeting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="newMeetingForm" method="POST" action="code.php">
                    <div class="form-group">
                        <label for="title">Meeting Name:</label>
                        <input type="text" id="title" name="title" class="form-control mb-2" placeholder="Meeting name"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="speaker">Speaker:</label>
                        <input type="text" id="speaker" name="speaker" class="form-control mb-2" placeholder="Speaker"
                            required>
                    </div>
                    <div class="form-group">
                        <label>Date:</label>
                        <input type="date" name="date" id="date" class="form-control datepicker" required>
                    </div>
                    <div class="form-group">
                        <label>Time:</label>
                        <div class="d-flex">
                            <div class="input-group ">
                                <input type="time" class="form-control" name="start_time" id="end_time"
                                    placeholder="Start time (e.g., 11:00)" required>
                            </div>
                            <div class="input-group ml-2">
                                <input type="time" class="form-control" name="end_time" id="end_time"
                                    placeholder="End time (e.g., 14:00)" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="link">Meeting Link:</label>
                        <input type="url" id="link" name="link" class="form-control mb-2" placeholder="Meeting Link"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <textarea id="description" name="description" class="form-control mb-2"
                            placeholder="Description" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="addMeeting">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteMeeting" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
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
                    <input type="hidden" value="<?=$meetingItem['id']?>" name="id" id="id" class="form-control">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">NO</button>
                        <button type="submit" class="btn btn-danger" name="deleteMeeting">YES</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'view/footer.php'?>