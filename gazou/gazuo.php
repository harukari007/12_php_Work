<?php
// upload.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($_FILES['fileInput']['name']);

        if (move_uploaded_file($_FILES['fileInput']['tmp_name'], $uploadFile)) {
            $response = [
                'success' => true,
                'imageUrl' => $uploadFile
            ];
        } else {
            $response = ['success' => false];
        }
    } else {
        $response = ['success' => false];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
