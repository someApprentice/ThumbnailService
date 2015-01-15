<?php
require_once '../autoload.php'
?>

<?php
class Upload {
    public function getExtension($name) {
        $extensions = array("jpeg", "jpg", "png");

        $explode = explode(".", $name);
        $extension = end($explode);

        if (!in_array($extension, $extensions)) {
            return false;
        } 

        return $extension;
    }

    public function generateHash($file) {
        $hash = md5_file($file);

        return $hash;
    }

    public function uploadFile($name, $temp, $extension, $width, $height, &$errors = array()) {
        if (file_exists("uploads/" . $name)) {
            $errors['nameExists'] = $name . " already exists. ";

            return false;
        }
        
        $database = new Database;

        $originalname = $name;
        $name = $database->newName($originalname);

        move_uploaded_file($temp, "uploads/" . $name);

        $hash = self::generateHash("uploads/" . $name);

        if ($database->validateImageHash($hash)) {
            unlink("uploads/" . $name);
            $errors['fileExist'] = 'Image already exists here: uploads/' . $image['name'];

            return false;        
        }

        if (!$database->addImage($originalname, $name, $hash, $extension)) {
            $errors['database'] = "Some database error";

            unlink("uploads/" . $name);

            return false;
        }

        if (($width != '' xor $height != '') or ($width != '' and $height != '')) {
            $thumbnail = new Thumbnail;

            $thumbnail->createThumbnail($name, $width, $height, false);
        }

        return true;
    }
}
?>