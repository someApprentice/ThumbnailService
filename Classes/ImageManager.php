<?php
require_once '/../autoload.php';
?>

<?php
class ImageManager {
	public static function uploadFile($name, $temp, $extension) {
		$upload = new Upload;
		$database = new Database;

		$directory = Functions::createDirectory($name);

        if (file_exists("uploads/" . $directory . '/' . $name) {
            $errors['nameExists'] = $name . " already exists. ";

            return true;
        }

		$upload->uploadFile($name, $temp, $directory);

		$hash = Functions::generateHash("uploads/" . $directory . '/' . $name);

        if (!$extension = Functions::getExtension($fileName)) {
            $errors['extension'] = "Incorrect extension";

            return false;
        }

        if ($database->validateImageHash($hash)) {
            unlink("uploads/" . $name);
            $errors['fileExist'] = 'Image already exists here: uploads/' . $directory . '/' . $image['name'];

            return false;        
        }

        if (!Functions::validateImage("uploads/" . $directory . '/' . $name)) {
            $erorrs['image'] = "Incorrect image";

            unlink("uploads/" . $name);

            return false;
        }


        if (!$database->addImage($name, $name, $hash, $extension, $directory)) {
            $errors['database'] = "Some database error";

            unlink("uploads/" . $directory . '/' . $name);

            return false;
        }

        return true;		
	}

	public static function createThumbnail($name, $width, $height, $crop) {
        $thumbnail = new Thumbnail($name, $width, $height, $crop);
        $upload = new Upload;
        $database = new Database;

        $directory = Functions::createDirectory($name);
        list($newWidth, $newHeight, $thumbnailName) = $thumbnail->calculateProperty($directory);

        if ($database->getThumbnailBySize($name, $newWidth, $newHeight)) {
            return false;
        }

        $thumbnailDirectory = Functions::createDirectory($thumbnailName);

        $thumbnail->createThumbnail($thumbnailDirectory, $thumbnailName);

        $hash = Functions::generateHash("thumbnails/" . $thumbnailDirectory . '/' . $thumbnailName);
        $database->addThumbnail($name, $thumbnailName, $hash, $newWidth, $newHeight, $thumbnailDirectory);
    }

    public static function deleteImageAndThumbnail() {
        $database = new Database;
        $delete = new Delete;

        $image = $database->getImageFromUrl();

        if (!isset($image)) exit;

        if (!$delete->deleteImageFromDrive($image['name'])) exit;
        $database->deleteImageFromDatabase($image['originalname']);

        if(!$delete->deleteThumbnailsFromDrive($image['name'])) exit;
        $database->deleteThumbnailsFromDatabase($image['originalname']);
    }
}
?>