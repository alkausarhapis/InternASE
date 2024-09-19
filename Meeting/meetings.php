<?php
include 'config.php';

$query = "SELECT id_meeting, title, speaker, date, start_time, end_time, meeting_link FROM meeting";
$result = $conn->query($query);

$meetings = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $meetings[] = $row;
    }
} else {
    echo "No meetings found.";
}

if (isset($_POST['add_meeting'])) {
    $title = $_POST['title'];
    $speaker = $_POST['speaker'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $meeting_link = $_POST['meeting_link'];
    $description = $_POST['description'];
    $id_meeting = rand(2,100);

    mysqli_query($conn,"INSERT INTO meeting VALUES ($id_meeting,'$title','$speaker', '$date', '$start_time','$end_time','$meeting_link','$description')");
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET['delete_id'])) {
    $id_meeting = $_GET['delete_id'];

    $stmt = $conn->prepare("DELETE FROM meeting WHERE id_meeting = ?");
    $stmt->bind_param('i', $id_meeting);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pertemuan</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        h1 {
            font-weight: 600;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .meeting-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }
        .meeting-table thead th {
            text-align: left;
            font-weight: 500;
            color: #444;
        }
        .meeting-table tbody tr {
            background-color: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            height: 60px;
        }
        .meeting-table tbody tr td {
            padding: 10px 15px;
            vertical-align: middle;
        }
        .meeting-table tbody tr td .meeting-link, .delete-icon {
            text-decoration: none;
            margin-right: 15px;
            font-size: 20px;
        }
        .meeting-link {
            color: #007bff;
        }
        .delete-icon {
            color: #dc3545;
            cursor: pointer;
        }
        .add-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .add-button:hover {
            background-color: #0056b3;
        }
        .new-meeting-modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            width: 400px;
        }
        .modal-header {
            font-weight: 600;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .modal-form input, .modal-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }
        .modal-form button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .modal-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h1>Daftar Pertemuan</h1>

<!-- List -->
<table class="meeting-table">
    <thead>
        <tr>
            <th>Title</th>
            <th>Item</th>
            <th>Date</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($meetings)): ?>
            <?php foreach ($meetings as $meeting): ?>
                <tr>
                    <td><?php echo htmlspecialchars($meeting['title']); ?></td>
                    <td><?php echo htmlspecialchars($meeting['speaker']); ?></td>
                    <td><?php echo htmlspecialchars($meeting['date']); ?></td>
                    <td><?php echo htmlspecialchars($meeting['start_time']) . " - " . htmlspecialchars($meeting['end_time']); ?></td>
                    <td>
                        <a href="<?php echo htmlspecialchars($meeting['meeting_link']); ?>" class="meeting-link" target="_blank">🔗</a>
                        <span class="delete-icon" onclick="confirmDelete(<?php echo $meeting['id_meeting']; ?>)">🗑️</span>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No meetings scheduled.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<!-- New Meeting Button -->
<button class="add-button" onclick="openModal()">New Meeting</button>

<!-- Modal Meeting -->
<div class="new-meeting-modal" id="newMeetingModal">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <div class="modal-header">New Meeting</div>
    <form class="modal-form" method="POST" action="">
        <input type="text" name="title" placeholder="Meeting name" required>
        <input type="text" name="speaker" placeholder="Speaker" required>
        <input type="date" name="date" required>
        <input type="time" name="start_time" required>
        <input type="time" name="end_time" required>
        <input type="text" name="meeting_link" placeholder="Meeting Link">
        <textarea name="description" placeholder="Description" rows="3"></textarea>
        <button type="submit" name="add_meeting">Save</button>
    </form>
</div>

<script>
    function openModal() {
        document.getElementById('newMeetingModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('newMeetingModal').style.display = 'none';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('newMeetingModal');
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this meeting?')) {
            window.location.href = '?delete_id=' + id;
        }
    }
</script>

</body>
</html>