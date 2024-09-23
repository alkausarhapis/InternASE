<?php

include('../config/function.php');
include('view/auth.php');

if (isset($_POST['saveAdmin'])) {
    $nim = validate($_POST['nim']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $nama = validate($_POST['nama']);

    if ($nim != '' && $username != '' && $password != '' && $nama != '') {
        $nimCheck = mysqli_query($conn, "SELECT * FROM admins WHERE nim='$nim'");
        $usernameCheck = mysqli_query($conn, "SELECT * FROM admins WHERE username='$username'");
        if ($nimCheck) {
            if (mysqli_num_rows($nimCheck) > 0) {
                redirect('admins.php', 'NIM Already Used.');
            }
        } else if ($usernameCheck) {
            if (mysqli_num_rows($usernameCheck) > 0) {
                redirect('admins.php', 'Username Already Used.');
            }
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'nim' => $nim,
            'username' => $username,
            'password' => $hashedPassword,
            'nama' => $nama
        ];
        // $result = insert('admins', $data);
        $result = insert('admins', $data);
        if ($result) {
            redirect('admins.php', 'Admin Created Successfully!.');
        } else {
            redirect('admins.php', 'Something Went Wrong.');
        }
    } else {
        redirect('admins.php', 'Please fill required fields.');
    }
}

if (isset($_POST['updateAdmin'])) {
    $nim = validate($_POST['nim']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $nama = validate($_POST['nama']);

    // check duplicate or nah
    $nimCheck = "SELECT * FROM admins WHERE nim='$nim' AND username!='$username'";
    $usernameCheck = "SELECT * FROM admins WHERE nim!='$nim' AND username='$username'";
    $nimCheckResult = mysqli_query($conn, $nimCheck);
    $usernameCheckResult = mysqli_query($conn, $usernameCheck);
    if ($nimCheckResult) {
        if (mysqli_num_rows($nimCheckResult) > 1) {
            redirect('admins.php', 'NIM Already Used.');
        }
    }
    if ($usernameCheckResult) {
        if (mysqli_num_rows($usernameCheckResult) > 0) {
            redirect('admins.php', 'Username Already Used.');
        }
    }

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $adminData['data']['password'];
    }

    if ($nim != '' && $username != '' && $nama != '') {
        $data = [
            'nim' => $nim,
            'username' => $username,
            'password' => $hashedPassword,
            'nama' => $nama
        ];
        // $result = insert('admins', $data);
        $result = updateNim('admins', $nim, $data);
        if ($result) {
            redirect('admins.php', 'Admin Updated Successfully!.');
        } else {
            redirect('admins.php', 'Something Went Wrong.');
        }
    } else {
        redirect('admins.php', 'Please fill required fields.');
    }
}

if (isset($_POST['deleteAdmin'])) {
    $nim = validate($_POST['nim']);

    if ($nim != '') {
        $result = deleteNim('admins', $nim);
        if ($result) {
            redirect('admins.php', 'Admin Deleted Successfully!.');
        } else {
            redirect('admins.php', 'Something Went Wrong.');
        }
    } else {
        redirect('admins.php', 'NIM not found.');
    }
}

if (isset($_POST['saveInventory'])) {
    $id = validate($_POST['id']);
    $item = validate($_POST['item']);
    $unit = validate($_POST['unit']);
    $date = validate($_POST['date']);
    if($_FILES['picture']['size'] > 0){
        $path ="../assets/uploads/inventaris";
        $picture_ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        $filename = time().'.'.$picture_ext;

        move_uploaded_file($_FILES['picture']['tmp_name'], $path."/".$filename);
        $finalPicture = "assets/uploads/inventaris/".$filename;
    } else {
        $finalPicture = '';
    }
    $description = validate($_POST['description']);


    if ($id != '' && $item != '' && $unit != '' && $date != '') {
        $idCheck = mysqli_query($conn, "SELECT * FROM inventory WHERE id='$id'");
        if ($idCheck) {
            if (mysqli_num_rows($idCheck) > 0) {
                redirect('inventaris.php', 'ID Already Used.');
            }
        }

        $data = [
            'id' => $id,
            'item' => $item,
            'unit' => $unit,
            'date' => $date,
            'picture' => $finalPicture,
            'description' => $description
        ];
        // $result = insert('tujuan table', $data);
        $result = insert('inventory', $data);
        if ($result) {
            redirect('inventaris.php', 'Item Added Successfully!.');
        } else {
            redirect('inventaris.php', 'Something Went Wrong.');
        }
    } else {
        redirect('inventaris.php', 'Please fill required fields.');
    }
}

if (isset($_POST['updateInventory'])) {
    $id = validate($_POST['id']);
    $inventoryData = getById('inventory', $id);

    if (!$inventoryData) {
        redirect('inventaris.php', 'No such item found');
    }

    $item = validate($_POST['item']);
    $unit = validate($_POST['unit']);
    $date = validate($_POST['date']);

    if ($_FILES['picture']['size'] > 0) {
        $path = "../assets/uploads/inventaris";
        $picture_ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        $filename = time() . '.' . $picture_ext;

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $path . "/" . $filename)) {
            $finalPicture = "assets/uploads/inventaris/" . $filename;

            // Hapus gambar lama jika ada
            $deleteImage = "../" . $inventoryData['data']['picture'];

            if (file_exists($deleteImage)) {
                if (unlink($deleteImage)) {
                    echo "Gambar lama berhasil dihapus.";
                } else {
                    echo "Gagal menghapus gambar lama.";
                }
            } else {
                echo "Gambar lama tidak ditemukan.";
            }
        } else {
            echo "Gagal mengupload gambar baru.";
            $finalPicture = $inventoryData['data']['picture']; // Tetap gunakan gambar lama jika upload gagal
        }
    } else {
        // Tetap gunakan gambar lama jika tidak ada gambar baru diunggah
        $finalPicture = $inventoryData['data']['picture'];
    }

    $description = validate($_POST['description']);

    if ($id != '' && $item != '' && $unit > '0') {
        $data = [
            'id' => $id,
            'item' => $item,
            'unit' => $unit,
            'date' => $date,
            'picture' => $finalPicture,
            'description' => $description
        ];

        // Update data ke dalam tabel inventory
        $result = update('inventory', $id, $data);
        if ($result) {
            redirect('inventaris.php', 'Item Updated Successfully!.');
        } else {
            redirect('inventaris.php', 'Something Went Wrong.');
        }
    } else {
        redirect('inventaris.php', 'Please fill required fields.');
    }
}

if (isset($_POST['deleteInventory'])) {
    $id = validate($_POST['id']);
    $inventoryData = getById('inventory', $id);

    if ($id != '' && $inventoryData) {
        // Hapus gambar jika ada sebelum menghapus data dari database
        $deleteImage = "../".$inventoryData['data']['picture'];

        if (file_exists($deleteImage) && !empty($inventoryData['data']['picture'])) {
            if (unlink($deleteImage)) {
                echo "Gambar berhasil dihapus.";
            } else {
                echo "Gagal menghapus gambar.";
            }
        }

        // Hapus data dari database
        $result = delete('inventory', $id);
        if ($result) {
            redirect('inventaris.php', 'Item Deleted Successfully!.');
        } else {
            redirect('inventaris.php', 'Something Went Wrong.');
        }
    } else {
        redirect('inventaris.php', 'ID not found or invalid.');
    }
}

if (isset($_POST['saveMembers'])) {
    $nim = validate($_POST['nim']);
    $fullname = validate($_POST['fullname']);
    $entry_year = validate($_POST['entry_year']);
    $age = validate($_POST['age']);
    $major = validate($_POST['major']);
    $faculty = validate($_POST['faculty']);
    if($_FILES['picture']['size'] > 0){
        $path ="../assets/uploads/members";
        $picture_ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        $filename = time().'.'.$picture_ext;

        move_uploaded_file($_FILES['picture']['tmp_name'], $path."/".$filename);
        $finalPicture = "assets/uploads/members/".$filename;
    } else {
        $finalPicture = '';
    }


    if ($nim != '' && $fullname != '' && $entry_year != '' && $major != '' && $faculty != '') {
        $nimCheck = mysqli_query($conn, "SELECT * FROM members WHERE nim='$nim'");
        if ($nimCheck) {
            if (mysqli_num_rows($nimCheck) > 0) {
                redirect('dataAnggota.php', 'NIM Already Used.');
            }
        }

        $data = [
            'nim' => $nim,
            'fullname' => $fullname,
            'entry_year' => $entry_year,
            'age' => $age,
            'major' => $major,
            'faculty' => $faculty,
            'picture' => $finalPicture,
        ];
        // $result = insert('tujuan table', $data);
        $result = insert('members', $data);
        if ($result) {
            redirect('dataAnggota.php', 'Member Added Successfully!.');
        } else {
            redirect('dataAnggota.php', 'Something Went Wrong.');
        }
    } else {
        redirect('dataAnggota.php', 'Please fill required fields.');
    }
}

if (isset($_POST['updateMembers'])) {
    $nim = validate($_POST['nim']);
    $membersData = getByNim('members', $nim);

    if (!$membersData) {
        redirect('dataAnggota.php', 'No such member found');
    }

    $fullname = validate($_POST['fullname']);
    $entry_year = validate($_POST['entry_year']);
    $age = validate($_POST['age']);
    $major = validate($_POST['major']);
    $faculty = validate($_POST['faculty']);

    if ($_FILES['picture']['size'] > 0) {
        $path = "../assets/uploads/members";
        $picture_ext = pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION);

        $filename = time() . '.' . $picture_ext;

        if (move_uploaded_file($_FILES['picture']['tmp_name'], $path . "/" . $filename)) {
            $finalPicture = "assets/uploads/members/" . $filename;

            // Hapus gambar lama jika ada
            $deleteImage = "../" . $membersData['data']['picture'];

            if (file_exists($deleteImage)) {
                if (unlink($deleteImage)) {
                    echo "Gambar lama berhasil dihapus.";
                } else {
                    echo "Gagal menghapus gambar lama.";
                }
            } else {
                echo "Gambar lama tidak ditemukan.";
            }
        } else {
            echo "Gagal mengupload gambar baru.";
            $finalPicture = $membersData['data']['picture']; // Tetap gunakan gambar lama jika upload gagal
        }
    } else {
        // Tetap gunakan gambar lama jika tidak ada gambar baru diunggah
        $finalPicture = $membersData['data']['picture'];
    }


    if ($nim != '' && $fullname != '' && $entry_year != '' && $major != '' && $faculty != '') {
        $data = [
            'nim' => $nim,
            'fullname' => $fullname,
            'entry_year' => $entry_year,
            'age' => $age,
            'major' => $major,
            'faculty' => $faculty,
            'picture' => $finalPicture,
        ];

        // Update data ke dalam tabel inventory
        $result = updateNim('members', $nim, $data);
        if ($result) {
            redirect('dataAnggota.php', 'Member Updated Successfully!.');
        } else {
            redirect('dataAnggota.php', 'Something Went Wrong.');
        }
    } else {
        redirect('dataAnggota.php', 'Please fill required fields.');
    }
}

if (isset($_POST['deleteMembers'])) {
    $nim = validate($_POST['nim']);
    $membersData = getByNim('members', $nim);

    if ($nim != '' && $membersData) {
        // Hapus gambar jika ada sebelum menghapus data dari database
        $deleteImage = "../".$membersData['data']['picture'];

        if (file_exists($deleteImage) && !empty($membersData['data']['picture'])) {
            if (unlink($deleteImage)) {
                echo "Gambar berhasil dihapus.";
            } else {
                echo "Gagal menghapus gambar.";
            }
        }

        // Hapus data dari database
        $result = deleteNim('members', $nim);
        if ($result) {
            redirect('dataAnggota.php', 'Member Deleted Successfully!.');
        } else {
            redirect('dataAnggota.php', 'Something Went Wrong.');
        }
    } else {
        redirect('dataAnggota.php', 'NIM not found or invalid.');
    }
}

if (isset($_POST['saveUser'])) {
    $id = validate($_POST['id']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $name = validate($_POST['name']);
    $role = validate($_POST['role']);

    if ($id != '' && $username != '' && $password != '' && $name != '' && $role != '') {
        $idCheck = mysqli_query($conn, "SELECT * FROM user WHERE id='$id'");
        if ($idCheck) {
            if (mysqli_num_rows($idCheck) > 0) {
                redirect('user.php', 'ID Already Used.');
            }
        } 

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'id' => $id,
            'username' => $username,
            'password' => $hashedPassword,
            'name' => $name,
            'role' => $role
        ];
        // $result = insert('admins', $data);
        $result = insert('user', $data);
        if ($result) {
            redirect('user.php', 'User Created Successfully!.');
        } else {
            redirect('user.php', 'Something Went Wrong.');
        }
    } else {
        redirect('user.php', 'Please fill required fields.');
    }
}

if (isset($_POST['updateUser'])) {
    $id = validate($_POST['id']);
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $name = validate($_POST['name']);
    $role = validate($_POST['role']);

    // check duplicate or nah
    $idCheck = "SELECT * FROM user WHERE id='$id' AND username!='$username'";
    $userCheckResult = mysqli_query($conn, $idCheck);
    if ($idCheckResult) {
        if (mysqli_num_rows($idCheckResult) > 1) {
            redirect('user.php', 'ID Already Used.');
        }
    }

    if ($password != '') {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        $hashedPassword = $userData['data']['password'];
    }

    if ($id != '' && $username != '' && $password != '' && $name != '' && $role != '') {
        $data = [
            'id' => $id,
            'username' => $username,
            'password' => $hashedPassword,
            'name' => $name,
            'role' => $role
        ];
        // $result = insert('admins', $data);
        $result = update('user', $id, $data);
        if ($result) {
            redirect('user.php', 'User Updated Successfully!.');
        } else {
            redirect('user.php', 'Something Went Wrong.');
        }
    } else {
        redirect('user.php', 'Please fill required fields.');
    }
}

if (isset($_POST['deleteUser'])) {
    $id = validate($_POST['id']);

    if ($id != '') {
        $result = delete('user', $id);
        if ($result) {
            redirect('user.php', 'User Deleted Successfully!.');
        } else {
            redirect('user.php', 'Something Went Wrong.');
        }
    } else {
        redirect('user.php', 'ID not found.');
    }
}

if (isset($_POST['borrowDocument'])) {  // Borrow button 
    $id = hexdec(uniqid());
    $return_time = $_POST['returnTime'];
    $id_document = $_POST['idDocument'];
    
    if ($return_time != '' && $id_document != '' ) {
        $idCheck = mysqli_query($conn, "SELECT * FROM borrow WHERE id='$id'");
        if ($idCheck) {
            while (mysqli_num_rows($idCheck) > 0) {
                $id = uniqid();                
            }
        } 

        $data = [
            'id' => $id,
            'return_time' => $return_time,
            'id_user' => $uid,
            'id_document' => $id_document
        ];
        // $result = insert('admins', $data);
        $result = insert('borrow', $data);
        if ($result) {
            $dataBorrow = [
                'status' => 'borrowed'
            ];
            $resultBorrow = update('document', $id_document, $dataBorrow );
            if (!$resultBorrow) {
                redirect('document.php', 'Document borrowed Status failed!');
            }
            redirect('document.php', 'Document borrowed successfully!');
        } else {
            redirect('document.php', 'Document borrowed Failed!');
        }
    } else {
        redirect('document.php', 'Please fill required fields.');
    }
    
    // $stmt = $conn->prepare("UPDATE borrow SET status='borrowed', id_user=1, return_time='$return_time' WHERE doc_id= $doc_id");
    // if ($stmt->execute()) {
    //     echo ("Document borrowed successfully!");
    // } else {
    //     echo ("gagal!");
    // }
    // $stmt->close();
    // header("Location: " . $_SERVER['PHP_SELF']);
    // exit();
}

if (isset($_POST['deleteDocument'])) {  // Delete button
    $id = $_POST['id'];
    
    if ($id != '') {
        $result = delete('document', $id);
        if ($result) {
            redirect('document.php', 'Document Deleted Successfully!.');
        } else {
            redirect('document.php', 'Something Went Wrong.');
        }
    } else {
        redirect('document.php', 'ID not found.');
    }
}

if (isset($_POST['addDocument'])) {  // Add button
    $id = uniqid();
    $tittle = $_POST['tittle'];
    $status = $_POST['status'];
    $author = $_POST['author'];
    
    if ($tittle != '' ) {
        $idCheck = mysqli_query($conn, "SELECT * FROM document WHERE id='$id'");
        if ($idCheck) {
            while (mysqli_num_rows($idCheck) > 0) {
                $id = uniqid();                
            }
        } 

        $data = [
            'id' => $id,
            'tittle' => $tittle,
            'status' => $status,
            'author' => $author
        ];
        // $result = insert('admins', $data);
        $result = insert('document', $data);
        if ($result) {
            redirect('document.php', 'Document Created Successfully!.');
        } else {
            redirect('document.php', 'Something Went Wrong.');
        }
    } else {
        redirect('document.php', 'Please fill required fields.');
    }
}

// if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['searchDocument'])) {  // Search button 
//     $search_query = $_GET['query'];
//     $stmt = $conn->prepare("SELECT * FROM document WHERE judul LIKE ?");
//     $like_query = '%' . $search_query . '%';
//     $stmt->bind_param('s', $like_query);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     while ($row = $result->fetch_assoc()) {
    //         // Fetch status
//         $status_query = $conn->prepare("SELECT status FROM borrow WHERE doc_id = ?");
//         $status_query->bind_param('i', $row['doc_id']);
//         $status_query->execute();
//         $status_result = $status_query->get_result();
//         if ($status_result->num_rows > 0) {
//             $status_row = $status_result->fetch_assoc();
//             $row['status'] = $status_row['status'];
//         } else {
//             $row['status'] = 'available';
//         }
//         $status_query->close();

//         $documents[] = $row;
//     }
//     $stmt->close();
// } else {
//     $result = $conn->query("SELECT * FROM document");
//     if ($result && $result->num_rows > 0) {
//         while ($row = $result->fetch_assoc()) {
//             $status_query = $conn->prepare("SELECT status FROM borrow WHERE doc_id = ? LIMIT 1");
//             $status_query->bind_param('i', $row['doc_id']);
//             $status_query->execute();
//             $status_result = $status_query->get_result();
//             if ($status_result->num_rows > 0) {
//                 $status_row = $status_result->fetch_assoc();
//                 $row['status'] = $status_row['status'];
//             } else {
//                 $row['status'] = 'available';
//             }
//             $status_query->close();

//             $documents[] = $row;
//         }
//     }
// }


if (isset($_POST['addMeeting'])) {
    $id = uniqid();
    $title = validate($_POST['title']);
    $speaker = validate($_POST['speaker']);
    $date = validate($_POST['date']);
    $start_time = validate($_POST['start_time']);
    $end_time = validate($_POST['end_time']);
    $link = validate($_POST['link']);
    $description = validate($_POST['description']);

    if ($id != '' && $title != '' && $speaker != '' && $date != '' && $start_time != '' && $end_time != '') {
        $idCheck = mysqli_query($conn, "SELECT * FROM meeting WHERE id='$id'");
        if ($idCheck) {
            if (mysqli_num_rows($idCheck) > 0) {
                redirect('daftarpertemuan.php', 'ID Already Used.');
            }
        } 

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'id' => $id,
            'title' => $title,
            'speaker' => $speaker,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'meeting_link' => $link,
            'description' => $description
        ];
        // $result = insert('admins', $data);
        $result = insert('meeting', $data);
        if ($result) {
            redirect('daftarpertemuan.php', 'User Created Successfully!.');
        } else {
            redirect('daftarpertemuan.php', 'Something Went Wrong.');
        }
    } else {
        redirect('daftarpertemuan.php', 'Please fill required fields.');
    }
}

if (isset($_POST['deleteMeeting'])) {  // Delete button
    $id = $_POST['id'];
    
    if ($id != '') {
        $result = delete('meeting', $id);
        if ($result) {
            redirect('daftarpertemuan.php', 'Meeting Deleted Successfully!.');
        } else {
            redirect('daftarpertemuan.php', 'Something Went Wrong.');
        }
    } else {
        redirect('daftarpertemuan.php', 'ID not found.');
    }
}