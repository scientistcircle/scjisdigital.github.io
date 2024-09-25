<?php
// Proses upload file dan data running text
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Upload CSV Imam
    if (isset($_FILES['imam_csv']) && $_FILES['imam_csv']['error'] == UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['imam_csv']['tmp_name'], '../uploads/petugas.csv');
    }

    // Upload Logo
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] == UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['logo']['tmp_name'], '../uploads/logo.png');
    }

    // Upload Background
    if (isset($_FILES['background']) && $_FILES['background']['error'] == UPLOAD_ERR_OK) {
        move_uploaded_file($_FILES['background']['tmp_name'], '../uploads/background.jpg');
    }

    // Update Running Text
    if (isset($_POST['running_text'])) {
        file_put_contents('../uploads/running_text.txt', $_POST['running_text']);
    }

    header('Location: admin.php');
    exit;
}
?>
