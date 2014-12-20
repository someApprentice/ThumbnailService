<?php
class Thumbnail {
    public function createThumbnail($name, $maxWidth, $maxHeight, $corp = false) {
        list($width, $height) = getimagesize(__DIR__ . '/../uploads/' . $name);

        if ($maxWidth == '' || $maxWidth > $width) $maxWidth = $width;
        if ($maxHeight == '' || $maxHeight > $height) $maxHeight = $height;
        
        $ratioX = $maxWidth / $width;
        $ratioY = $maxHeight / $height;
        $ratio = min(array($ratioX, $ratioY));

        $newWidth = round($width * $ratio);
        $newHeight = round($height * $ratio);

        if (!Database::getThumbnailBySize($name, $newWidth, $newHeight)) {
            $image_p = imagecreatetruecolor($newWidth, $newHeight);
            $image = imagecreatefromjpeg(__DIR__ . '/../uploads/' . $name);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            $thumbnailName = 'thumbnail' . $newWidth . 'x' . $newHeight . '_' . $name;

            imagejpeg($image_p, __DIR__ . '/../thumbnails/' . $thumbnailName, 100);

            $hash = Upload::generateHash("thumbnails/" . $thumbnailName);

            Database::addThumbnail($name, $thumbnailName, $hash, $newWidth, $newHeight);
        }

        /*$link = 'thumbnails/' . $thumbnailName;

        return $link;*/
    }
}
?>