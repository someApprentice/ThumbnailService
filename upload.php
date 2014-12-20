<?php
spl_autoload_register(function ($className) {
    if(file_exists('Classes/' . $className . '.php')) {
        require_once __DIR__ . '/Classes/' . $className . '.php';

        return true;
    } else {
        return false;
    }
});

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $extensions = array("jpeg", "jpg", "png");
    $temp = explode(".", $_FILES["file"]["name"]);
    $extension = end($temp);


    if (Upload::extension($_FILES, $extension, $extensions)) {
        if ($_FILES["file"]["error"] > 0) {
            $errors["error"] = $_FILES["file"]["error"];
        } else {
            $fileName = $_FILES["file"]["name"];
            $fileType = $_FILES["file"]["type"];
            $fileSize = $_FILES["file"]["size"] / 1024;
            $fileTemp = $_FILES["file"]["tmp_name"];

            $thumbnailWidth = isset($_POST['width']) && is_scalar($_POST['width']) ? $_POST['width'] : '';
            $thumbnailHeight = isset($_POST['height']) && is_scalar($_POST['height']) ? $_POST['height'] : '';

            $errors = array();        

            Upload::uploadFile($fileName, $fileTemp, $extension, $thumbnailWidth, $thumbnailHeight, $errors);

            $fileName = Database::newName($fileName);

            header("Location: image.php?name=" . $fileName);
        }
    } else {
        echo "Invalid file";
    }
} else {
    header("Location: index.php");
}
?>