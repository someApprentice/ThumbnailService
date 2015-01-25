<?php
require_once '/../autoload.php'
?>

<?php
class Delete {
	public function deleteImageFromDrive($image) {
        $crc32 = abs(crc32($image));
        $directory = round($crc32 / pow(20, 6));

		if (file_exists("uploads/" . $directory . '/' . $image)) { 
			unlink("uploads/" . $directory . '/' . $image);
		} else {
			return false;
		}

		return true;
	} 

	public function deleteThumbnailsFromDrive($originalname) {
		if ($thumbnails = Database::getThumbnailsByImage($originalname)) {
			foreach ($thumbnails as $key => $value) {
				$crc32 = abs(crc32($value['name']));
	        	$directory = round($crc32 / pow(20, 6));

				if (file_exists("thumbnails/" . $directory . '/' . $value['name'])) {
					unlink("thumbnails/" . $directory . '/' . $value['name']);
				} else {
					return false;
				}
			}
		}

		return true;
	}
}
?>