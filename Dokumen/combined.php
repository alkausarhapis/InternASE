<?php
session_start();
include 'config.php'; 

$documents = [];
$search_query = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['search'])) {  // Search button 
    $search_query = $_GET['query'];
    $stmt = $conn->prepare("SELECT * FROM dokumen WHERE judul LIKE ?");
    $like_query = '%' . $search_query . '%';
    $stmt->bind_param('s', $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        // Fetch status
        $status_query = $conn->prepare("SELECT status FROM borrow WHERE doc_id = ?");
        $status_query->bind_param('i', $row['doc_id']);
        $status_query->execute();
        $status_result = $status_query->get_result();
        if ($status_result->num_rows > 0) {
            $status_row = $status_result->fetch_assoc();
            $row['status'] = $status_row['status'];
        } else {
            $row['status'] = 'available';
        }
        $status_query->close();

        $documents[] = $row;
    }
    $stmt->close();
} else {
    $result = $conn->query("SELECT * FROM dokumen");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $status_query = $conn->prepare("SELECT status FROM borrow WHERE doc_id = ? LIMIT 1");
            $status_query->bind_param('i', $row['doc_id']);
            $status_query->execute();
            $status_result = $status_query->get_result();
            if ($status_result->num_rows > 0) {
                $status_row = $status_result->fetch_assoc();
                $row['status'] = $status_row['status'];
            } else {
                $row['status'] = 'available';
            }
            $status_query->close();

            $documents[] = $row;
        }
    }
}

if (isset($_POST['add_document'])) {  // Add button
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $deskripsi = $_POST['deskripsi'];
    $id = rand(12,100);

    if (empty($judul) || empty($penulis) || empty($deskripsi)) {
        $message = "All fields are required to add a document.";
    } else {
        mysqli_query($conn,"INSERT INTO dokumen VALUES ($id,'$judul', '$penulis', '$deskripsi')");
        mysqli_query($conn,"INSERT INTO borrow (status, id_user, doc_id) VALUES ('available', 1, $id)");
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

if (isset($_POST['borrow'])) {  // Borrow button 
    $doc_id = $_POST['doc_id'];
    //$borrower = $_SESSION['id_user']; 
    $return_time = $_POST['return_time'];

    $stmt = $conn->prepare("UPDATE borrow SET status='borrowed', id_user=1, return_time='$return_time' WHERE doc_id= $doc_id");
    if ($stmt->execute()) {
        echo ("Document borrowed successfully!");
    } else {
        echo ("gagal!");
    }
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['delete'])) {  // Delete button
    $doc_id = $_POST['doc_id'];
    
    $stmt = $conn->prepare("DELETE FROM dokumen WHERE doc_id = ?");
    $stmt->bind_param('i', $doc_id);
    if ($stmt->execute()) {
        $message = "Document deleted successfully!";
    } else {
        $message = "Error deleting document.";
    }
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
    <title>Document Management</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; }
        .header h1 { margin: 0; }
        .documents { margin-top: 20px; }
        .document-item { padding: 10px; border: 1px solid #ddd; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .button { padding: 5px 10px; background-color: orange; color: white; border: none; cursor: pointer; }
        .button:hover { background-color: darkorange; }
        .status { padding: 5px 10px; background-color: #ccffcc; color: green; border-radius: 5px; }
        .add-document { margin-top: 20px; }
        .message { color: red; }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal.active {
            display: flex;
        }
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            max-width: 90%;
        }
        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            text-decoration: none;
            color: #333;
            font-size: 24px;
        }
        .modal-header, .modal-body, .modal-footer {
            margin-bottom: 10px;
        }
        .modal-footer {
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Documents</h1>
            <form method="GET" action="">
                <input type="text" name="query" placeholder="Search..." value="<?php echo htmlspecialchars($search_query); ?>">
                <button type="submit" name="search" class="button">Search</button>
            </form>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!--List-->
        <div class="documents">
    <?php foreach ($documents as $document): ?>
        <div class="document-item">
            <div>
                <strong><?php echo htmlspecialchars($document['judul']); ?></strong><br>
                <em><?php echo htmlspecialchars($document['penulis']); ?></em>
            </div>
            <div class="status">
                <?php
                echo htmlspecialchars($document['status']);
                ?>
            </div>
            <button class="button open-modal" data-doc-id="<?php echo htmlspecialchars($document['doc_id']); ?>" data-judul="<?php echo htmlspecialchars($document['judul']); ?>" data-penulis="<?php echo htmlspecialchars($document['penulis']); ?>" <?php if ($document['status'] === 'borrowed') echo 'disabled'; ?>>
                Borrow
            </button>
            <button class="button delete-modal" data-doc-id="<?php echo htmlspecialchars($document['doc_id']); ?>">
                🗑️ 
        </button>
        </div>
    <?php endforeach; ?>
</div>

<!-- Borrow Modal -->
<div id="borrowModal" class="modal">
    <div class="modal-content">
        <a href="#" class="close-modal">&times;</a>
        <div class="modal-header">
            <h2>Borrow Document</h2>
        </div>
        <div class="modal-body">
            <p><strong id="modal-judul"></strong></p>
            <p><em id="modal-penulis"></em></p>
            <form method="POST" action="">
                <input type="hidden" name="doc_id" id="modal-doc-id" />
                <label for="returnTime">Return Time:</label> <!-- Make sure 'for' matches 'id' -->
                <input type="datetime-local" name="return_time" id="returnTime" required />
                <div class="modal-footer">
                    <button type="button" class="button close-modal">Cancel</button>
                    <button type="submit" name="borrow" class="button">Confirm Borrow</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <a href="#" class="close-modal">&times;</a>
        <div class="modal-header">
            <h2>Confirm Delete</h2>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this document?</p>
            <form method="POST" action="">
                <input type="hidden" name="doc_id" id="delete-doc-id" />
                <div class="modal-footer">
                    <button type="button" class="button close-modal">Cancel</button>
                    <button type="submit" name="delete" class="button">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="add-document">
    <h2>New Document</h2>
    <form method="POST" action="">
        <label for="judul">Title:</label>
        <input type="text" name="judul" id="judul" placeholder="Title" required />

        <label for="penulis">Author:</label>
        <input type="text" name="penulis" id="penulis" placeholder="Author" required />

        <label for="deskripsi">Description:</label>
        <textarea name="deskripsi" id="deskripsi" placeholder="Description" required></textarea>

        <button type="submit" name="add_document" class="button">Add Document</button>
    </form>
</div>

<script>
   // JavaScript to handle modal open/close and dynamic content
const modal = document.getElementById('borrowModal');
const closeModalButtons = document.querySelectorAll('.close-modal');
const openModalButtons = document.querySelectorAll('.open-modal');
const modalJudul = document.getElementById('modal-judul');
const modalPenulis = document.getElementById('modal-penulis');
const modalDocId = document.getElementById('modal-doc-id');

// Open modal when clicking the "Borrow" button
openModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Retrieve the data attributes from the button
        const docId = button.getAttribute('data-doc-id');
        const judul = button.getAttribute('data-judul');
        const penulis = button.getAttribute('data-penulis');

        // Set the modal content with the document data
        modalJudul.textContent = judul;
        modalPenulis.textContent = penulis;
        modalDocId.value = docId;

        // Show the modal
        modal.classList.add('active');
    });
});

// Close the modal when clicking on any "close-modal" button
closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        modal.classList.remove('active');
    });
});

// Close modal when clicking outside the modal content
window.addEventListener('click', event => {
    if (event.target === modal) {
        modal.classList.remove('active');
    }
});

// Select the delete modal and its dynamic elements
const deleteModal = document.getElementById('deleteModal');
const deleteDocId = document.getElementById('delete-doc-id');

// Open delete modal when clicking the trash icon (delete button)
document.querySelectorAll('.delete-modal').forEach(button => {
    button.addEventListener('click', () => {
        const docId = button.getAttribute('data-doc-id');
        deleteDocId.value = docId;  // Set the hidden input value with the doc ID
        deleteModal.classList.add('active');
    });
});

// Close modal when clicking close button or outside the modal
closeModalButtons.forEach(button => {
    button.addEventListener('click', () => {
        modal.classList.remove('active');
        deleteModal.classList.remove('active');
    });
});

window.addEventListener('click', event => {
    if (event.target === deleteModal || event.target === modal) {
        modal.classList.remove('active');
        deleteModal.classList.remove('active');
    }
});

</script>
