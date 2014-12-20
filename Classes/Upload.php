<?php
spl_autoload_register(function ($className) {
    if(file_exists('Classes/' . $className . '.php')) {
        require_once __DIR__ . '/Classes/' . $className . '.php';

        return true;
    } else {
        return false;
    }
});

class Upload {
    public function extension($files, $extension, $extensions) {
        if (
            (
                ($files["file"]["type"] == "image/jpeg")
                || ($files["file"]["type"] == "image/jpg")
                || ($files["file"]["type"] == "image/pjpeg")
                || ($files["file"]["type"] == "image/x-png")
                || ($files["file"]["type"] == "image/png")
            )
            && ($files["file"]["size"] < 20000000)
            && in_array($extension, $extensions)
        ) {
            return true;
        } 
    }

    public function generateHash($file) {
        $hash = md5_file($file);

        return $hash;
    }

    public function uploadFile($name, $temp, $extension, $width, $height, &$errors = array()) {
        if (file_exists("uploads/" . $name)) {
            $errors['nameExists'] = $name . " already exists. ";

            //return false;
        } else {
            $originalname = $name;
            $name = Database::newName($originalname);
            move_uploaded_file($temp, "uploads/" . $name);

            $hash = self::generateHash("uploads/" . $name);

            if (!Database::validateImageHash($hash)) {
                if (!Database::addImage($originalname, $name, $hash, $extension)) {
                    $errors['database'] = "Some database error";

                    unlink("uploads/" . $name);

                    return false;
                }
            } else {
                unlink("uploads/" . $name);
                $errors['fileExist'] = 'Image already exists here: uploads/' . $image['name'];        
            }
        }

        if (($width != '' xor $height != '') or ($width != '' and $height != '')) {
            Thumbnail::createThumbnail($name, $width, $height, false);
        }

        return true;
    }

    public function test($name) {
        $newName = Database::newName($name);

        echo $name . "<br>";
        echo $newName . "<br>";
    }
}
?>