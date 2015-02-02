<?php
require_once '/../autoload.php';
?>

<?php
class Functions {
	    public static function createDirectory($fileName) {
        $crc32 = abs(crc32($fileName));
        $directory = round($crc32 / pow(20, 6));

        $path = (preg_match('/thumbnail(\\w+)/', $fileName)) ? 'thumbnails' : 'uploads';
        $path = $path . '/' . $directory . '/';

        if (!file_exists($path)) mkdir($path);        

        return $directory; 
    }

    public static function validateImage($name) {
        $image = getimagesize("uploads/" . $name);
        $extensions = array("image/jpeg", "image/png");

        if (!in_array($image['mime'], $extensions)) return false;

        return $image['mime'];
    }

    public static function getExtension($name) {
        $extensions = array("jpeg", "jpg", "png");

        $explode = explode(".", $name);
        $extension = mb_strtolower(end($explode));

        if (!in_array($extension, $extensions)) {
            return false;
        } 

        return $extension;
    }

    public static function generateHash($file) {
        $hash = md5_file($file);

        return $hash;
    }
}
?>