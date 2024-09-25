<?php
if (isset($_POST['running_text'])) {
    file_put_contents('uploads/running-text.txt', $_POST['running_text']);
    echo "Running text updated.";
} else {
    echo "No running text provided.";
}
?>
