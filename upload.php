<?php
// Updated upload.php to fix duplicate code and parse error

// Function to handle file uploads
function uploadFile($file) {
    // Check if file is uploaded
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid parameters.');
    }

    // Check for upload error
    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }

    // Check if file is of the correct type
    $fileType = mime_content_type($file['tmp_name']);
    if ($fileType !== 'image/jpeg' && $fileType !== 'image/png') {
        throw new RuntimeException('Invalid file format.');
    }

    // Move uploaded file
    $destination = 'uploads/' . basename($file['name']);
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
    return 'File uploaded successfully.';
}

// Process uploads from POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    try {
        $result = uploadFile($_FILES['upload']);
        echo json_encode(['success' => true, 'message' => $result]);
    } catch (RuntimeException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}