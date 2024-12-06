<?php
include '../functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['designUpload']) && isset($_POST['designName'])) {
        //get data
        $designName = $_POST['designName'];
        $designFile = $_FILES['designUpload'];

        //upload dirctory
        $uploadDir = '../uploads/';
        $filePath = $uploadDir . basename($designFile['name']); //get file path

        //  move the uploded file to the uploads file
        if (move_uploaded_file($designFile['tmp_name'], $filePath)) {
            $status = addDesign($designName, $filePath);
            if ($status) {
                echo json_encode(['status' => 'success', 'message' => 'Design uploaded successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to save design in the database']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to upload file']);
        }
    }

    //remove design
    if (isset($_POST['action']) && $_POST['action'] == 'remove' && isset($_POST['name'])) {
        $designName = $_POST['name'];
        //call function
        $status = removeDesign($designName);
        if ($status) {
            echo json_encode(['status' => 'success', 'message' => 'Design removed successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to remove design']);
        }
    }
}
?>
