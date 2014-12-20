<?php
spl_autoload_register(function ($className) {
    if(file_exists('Classes/' . $className . '.php')) {
        require_once __DIR__ . '/Classes/' . $className . '.php';

        return true;
    } else {
        return false;
    }
});

class Database {
	public function newName($originalname) {
		$originalname = explode('.', $originalname);
		$extension = array(end($originalname));
		$originalname = array_diff($originalname, $extension);
		$extension = implode($extension);
		$originalname = implode('.', $originalname);

			
		$ru = "А а Б б В в Г г Д д Е е Ё ё Ж ж З з И и Й й К к Л л М м Н н О о П п Р р С с Т т У у Ф ф Х х Ц ц Ч ч Ш ш Щ щ Ъ ъ Ы ы Ь ь Э э Ю ю Я я";
		$ruExplode = explode(' ' , $ru);
		foreach ($ruExplode as &$value) {
			$value = '/' . $value . '/';
		}

		$eng = "A a B b V v G g D d E e Yo yo Zh zh Z z I i Y y K k L l M m N n O o P p R r S s T t U u F f H h Ts ts Ch ch Sh sh Shch shch '' '' I i '' '' E e YU yu Ya ya";
		$engExplode = explode(' ', $eng);

		$originalname = preg_replace($ruExplode, $engExplode, $originalname);
		$originalname = preg_replace('/[^\\w-]/', '_', $originalname);
		$originalname = "{$originalname}.{$extension}";

		return $originalname;
	}

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

	public function addImage($originalName, $name, $hash, $type) {
		$connect = Connect::getPdo();

		$insert = $connect->prepare("INSERT INTO images (id, originalname, name, hash, type) VALUES (NULL, :originalname, :name, :hash, :type)");
		$insert->execute(array(
			':originalname' => $originalName,
			':name' => $name,
			':hash' => $hash,
			':type' => $type
			));

		return $insert;
	}

	public function addThumbnail($originalName, $name, $hash, $width, $height) {
		$connect = Connect::getPdo();

		$insert = $connect->prepare("INSERT INTO thumbnails (id, originalName, name, hash, width, height) VALUES (NULL, :originalName, :name, :hash, :width, :height)");
		$insert->execute(array(
			':originalName' => $originalName,
			':name' => $name,
			':hash' => $hash,
			':width' => $width,
			':height' => $height
			));

		return $insert;
	}
}
?>