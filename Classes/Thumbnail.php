<?php
class Thumbnail {
    public function createThumbnail($name, $maxWidth, $maxHeight, $crop) {
        $directory = Upload::createDirectory($name);
        list($width, $height) = getimagesize(__DIR__ . '/../uploads/' . $directory . '/' . $name);

        $x = 0;
        $y = 0;

        $cropX = 0;
        $cropY = 0;

        if ($maxWidth == '' || $maxWidth > $width) $maxWidth = $width;
        if ($maxHeight == '' || $maxHeight > $height) $maxHeight = $height;

        if ($crop) {
            $cropRatioX = $maxWidth / $width;
            $cropRatioY = $maxHeight / $height;
            $cropRatio = max(array($cropRatioX, $cropRatioY));

            $newWidth = round($width * $cropRatio);
            $newHeight = round($height * $cropRatio);

            $cropX = ($newWidth > $newHeight) ? ($newWidth - $maxWidth) / 2 : 0;
            $cropY = ($newHeight > $newWidth) ? ($newWidth - $maxWidth) / 2 : 0;

            $x = ($maxWidth > $maxHeight) ? ($cropX / 2) * (-1) : 0;
            $y = ($maxHeight > $maxWidth) ? ($cropY / 2) * (-1) : 0;

            $newWidth_p = $maxWidth;
            $newHeight_p = $maxHeight;          
        } else {
            $ratioY = $maxWidth / $width;
            $ratioX = $maxHeight / $height;
            $ratio = min(array($ratioX, $ratioY));

            $newWidth = round($width * $ratio);
            $newHeight = round($height * $ratio); 

            $newWidth_p = $newWidth;
            $newHeight_p = $newHeight;              
        }   
        
        if (Database::getThumbnailBySize($name, $newWidth_p, $newHeight_p)) {
            return false;
        }

        $image_p = imagecreatetruecolor($newWidth_p, $newHeight_p);
        $image = imagecreatefromjpeg(__DIR__ . '/../uploads/' . $directory . '/' . $name);
        imagecopyresampled($image_p, $image, $x, $y, $cropX, $cropY, $newWidth, $newHeight, $width, $height);

        $thumbnailName = 'thumbnail' . $newWidth_p . 'x' . $newHeight_p . '_' . $name;

        $thumbnailDirectory = Upload::createDirectory($thumbnailName);

        imagejpeg($image_p, __DIR__ . '/../thumbnails/' . $thumbnailDirectory . '/' . $thumbnailName, 100);

        $hash = Upload::generateHash("thumbnails/" . $thumbnailDirectory . '/' . $thumbnailName);

        Database::addThumbnail($name, $thumbnailName, $hash, $newWidth_p, $newHeight_p, $thumbnailDirectory);
        

        /*$link = 'thumbnails/' . $thumbnailName;

        return $link;*/
    }
}
?>