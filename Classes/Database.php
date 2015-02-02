<?php
require_once '/../autoload.php'
?>

<?php
class Database {
	public function deleteThumbnailsFromDatabase($originalName) {
	    $connect = Connect::getPdo();

	    $thumbnails = $connect->prepare("DELETE FROM thumbnails WHERE originalName=:originalName");
	    $thumbnails->bindValue(':originalName', $originalName, PDO::PARAM_STR);
	    $thumbnails->execute();

	    return true;
	}	

	public function deleteImageFromDatabase($originalName) {
	    $connect = Connect::getPdo();

	    $image = $connect->prepare("DELETE FROM images WHERE originalName=:originalName");
	    $image->bindValue(':originalName', $originalName, PDO::PARAM_STR);
	    $image->execute();

	    return true;
	}	

	public function getThumbnailsByImage($originalName) {
	    $connect = Connect::getPdo();

	    $query = $connect->prepare("SELECT * FROM thumbnails WHERE originalName=:originalName");
	    $query->bindValue(':originalName', $originalName, PDO::PARAM_STR);
	    $query->execute();
	    $result = $query->fetchAll();

	    return $result;
	}

	public function getThumbnailBySize($originalName, $width, $height) {
	    $connect = Connect::getPdo();

	    $query = $connect->prepare("SELECT * FROM thumbnails WHERE originalName=:originalName AND width=:width AND height=:height");
	    $query->bindValue(':originalName', $originalName, PDO::PARAM_STR);
	    $query->bindValue(':width', $width, PDO::PARAM_INT);
	    $query->bindValue(':height', $height, PDO::PARAM_INT);
	    $query->execute();
	    $result = $query->fetch(PDO::FETCH_ASSOC);

	    return $result;
	}


	public function getImageFromUrl() {
		$name = isset($_GET['name']) ? $_GET['name'] : '';

	    $connect = Connect::getPdo();

	    $query = $connect->prepare("SELECT * FROM images WHERE name=:name");
	    $query->bindValue(':name', $name, PDO::PARAM_STR);
	    $query->execute();
	    $result = $query->fetch(PDO::FETCH_ASSOC);

	    return $result;
	}

	public function validateImageHash($hash) {
	    $connect = Connect::getPdo();

	    $query = $connect->prepare("SELECT * FROM images WHERE hash=:hash");
	    $query->bindValue(':hash', $hash, PDO::PARAM_STR);
	    $query->execute();
	    $result = $query->fetch(PDO::FETCH_ASSOC);

	    return $result;
	}

	public function addImage($originalName, $name, $hash, $type, $directory) {
		$connect = Connect::getPdo();

		$insert = $connect->prepare("INSERT INTO images (id, originalname, name, hash, type, directory) VALUES (NULL, :originalname, :name, :hash, :type, :directory)");
		$insert->execute(array(
			':originalname' => $originalName,
			':name' => $name,
			':hash' => $hash,
			':type' => $type,
			':directory' => $directory
			));

		return $insert;
	}

	public function addThumbnail($originalName, $name, $hash, $width, $height, $directory) {
		$connect = Connect::getPdo();

		$insert = $connect->prepare("INSERT INTO thumbnails (id, originalName, name, hash, width, height, directory) VALUES (NULL, :originalName, :name, :hash, :width, :height, :directory)");
		$insert->execute(array(
			':originalName' => $originalName,
			':name' => $name,
			':hash' => $hash,
			':width' => $width,
			':height' => $height,
			':directory' => $directory
			));

		return $insert;
	}
}
?>