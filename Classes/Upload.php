<?php
require_once '/../autoload.php';
?>

<?php
class Upload {
    public function uploadFile($name, $temp, $directory) {       
        move_uploaded_file($temp, "uploads/" . $directory . '/' . $name);

        return true;
    }
}
?>