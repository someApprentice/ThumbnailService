<?php
require_once '/../autoload.php';
?>

<?php
class Upload {
    public function createDirectory($fileName) {
        $crc32 = abs(crc32($fileName));
        $directory = round($crc32 / pow(20, 6));

        $path = (preg_match('/thumbnail(\\w+)/', $fileName)) ? 'thumbnails' : 'uploads';
        $path = $path . '/' . $directory . '/';

        if (!file_exists($path)) mkdir($path);        

        return $directory; 
    }

    public function validateImage($name) {
        $image = getimagesize("uploads/" . $name);
        $extensions = array("image/jpeg", "image/png");

        if (!in_array($image['mime'], $extensions)) return false;

        return $image['mime'];
    }

    public function getExtension($name) {
        $extensions = array("jpeg", "jpg", "png");

        $explode = explode(".", $name);
        $extension = mb_strtolower(end($explode));

        if (!in_array($extension, $extensions)) {
            return false;
        } 

        return $extension;
    }

    public function generateHash($file) {
        $hash = md5_file($file);

        return $hash;
    }

    public function uploadFile($name, $temp, $extension, $width, $height, $crop, &$errors = array()) {
        if (file_exists("uploads/" . $name)) {
            $errors['nameExists'] = $name . " already exists. ";

            if (($width != '' xor $height != '') or ($width != '' and $height != '')) {
                $thumbnail = new Thumbnail;

                $thumbnail->createThumbnail($name, $width, $height, $crop);
            }

            return true;
        }
        
        $database = new Database;

        $originalname = $name;
        $name = $database->newName($originalname);

        $directory = self::createDirectory($name);
        move_uploaded_file($temp, "uploads/" . $directory . '/' . $name);

        $hash = self::generateHash("uploads/" . $directory . '/' . $name);

        if ($database->validateImageHash($hash)) {
            unlink("uploads/" . $name);
            $errors['fileExist'] = 'Image already exists here: uploads/' . $directory . '/' . $image['name'];

            return false;        
        }

        /*if (!self::validateImage("uploads/" . $name)) {
            $erorrs['image'] = "Incorrect image";

            unlink("uploads/" . $name);

            return false;
        }*/

        if (!$database->addImage($originalname, $name, $hash, $extension, $directory)) {
            $errors['database'] = "Some database error";

            unlink("uploads/" . $directory . '/' . $name);

            return false;
        }

        if (($width != '' xor $height != '') or ($width != '' and $height != '')) {
            $thumbnail = new Thumbnail;

            $thumbnail->createThumbnail($name, $width, $height, $crop);
        }

        return true;
    }
}
?>