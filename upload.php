<?php
require_once 'autoload.php'
?>

<?php
$fileName = '';
$fileType = '';
$fileSize = '';
$fileTemp = '';

$errors = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fileName = $_FILES["file"]["name"];
    $fileType = $_FILES["file"]["type"];
    $fileSize = $_FILES["file"]["size"] / 1024;
    $fileTemp = $_FILES["file"]["tmp_name"];

    $thumbnailWidth = isset($_POST['width']) && is_scalar($_POST['width']) ? $_POST['width'] : '';
    $thumbnailHeight = isset($_POST['height']) && is_scalar($_POST['height']) ? $_POST['height'] : '';

    $crop = isset($_POST['Crop']) && $_POST['Crop'] == 'Crop' ? true : false;

    $form = new Form;
    $errors = $form->validateForm($fileName, $fileType, $fileTemp);

    if($errors) exit;

    $upload = new Upload;
    
    if (!$extension = $upload->getExtension($fileName)) {
        $errors['extension'] = "Incorrect extension";

        exit;
    }

    if ($_FILES["file"]["error"] > 0) {
        $errors["error"] = $_FILES["file"]["error"];

        exit;
    } 

    $upload->uploadFile($fileName, $fileTemp, $extension, $thumbnailWidth, $thumbnailHeight, $crop, $errors);

    $database = new Database;
    $fileName = $database->newName($fileName);

    header("Location: image.php?name=" . urlencode($fileName));    
} else {
    header("Location: index.php");
}
?>