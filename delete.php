<?php
spl_autoload_register(function ($className) {
    if(file_exists('Classes/' . $className . '.php')) {
        require_once __DIR__ . '/Classes/' . $className . '.php';

        return true;
    } else {
        return false;
    }
});

$image = Database::getImageFromUrl();

if (isset($image)) {
	if (Delete::deleteImageFromDrive($image['name'])) {
		Database::deleteImageFromDatabase($image['originalname']);

		if (Delete::deleteThumbnailsFromDrive($image['name'])) {
			Database::deleteThumbnailsFromDatabase($image['originalname']);
		}

		
	}
}

header("Location: index.php");
?>
