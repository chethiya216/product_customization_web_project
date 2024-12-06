<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['designUpload'])) {
    //to define the upload directory
    $uploadDir = 'uploads/';
    $filename = basename($_FILES['designUpload']['name']); 
    $relativePath = $uploadDir . $filename; 
    $physicalPath = __DIR__ . '/' . $relativePath;

    if (move_uploaded_file($_FILES['designUpload']['tmp_name'], $physicalPath)) {
        $status = addDesign($_POST['designName'], $filename); //to insert the design name and filename into the database
        if ($status) {
            echo json_encode(['status' => 'success', 'filename' => $filename]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to save design in the database']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded.']);
}
?>