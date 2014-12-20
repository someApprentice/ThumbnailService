<?php
spl_autoload_register(function ($className) {
    if(file_exists('Classes/' . $className . '.php')) {
        require_once __DIR__ . '/Classes/' . $className . '.php';

        return true;
    } else {
        return false;
    }
});

class Delete {
	public function deleteImageFromDrive($image) {
		if (file_exists("uploads/" . $image)) { 
			unlink("uploads/" . $image);
		} else {
			return false;
		}

		return true;
	} 

	public function deleteThumbnailsFromDrive($originalname) {
		if ($thumbnails = Database::getThumbnailsByImage($originalname)) {
			foreach ($thumbnails as $key => $value) {
				if (file_exists("thumbnails/" . $value['name'])) {
					unlink("thumbnails/" . $value['name']);
				} else {
					return false;
				}
			}
		}

		return true;
	}

	public function deleteTest() {
		$way = "uploads/" . "tumblr_mtfyqiOmNg1qetnlco1_500.jpg";
		
		if (file_exists($way)) {
			if(unlink($way)) {
				echo "unlink";
			}
		}
	}
}
?>