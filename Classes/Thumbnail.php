<?php
class Thumbnail {
    public $name;

    public $crop = false;

    public $width;
    public $height;
    
    public $maxWidth;
    public $maxHeight;

    public $x = 0;
    public $y = 0;

    public $cropX = 0;
    public $cropY = 0;

    public $newWidth;
    public $newHeight;

    public $newWidth_p;
    public $newHeight_p;

    public function __construct($name, $maxWidth, $maxHeight, $crop) {
        $this->name = $name;
        $this->maxWidth = $maxWidth;
        $this->maxHeight = $maxHeight;
        $this->crop = $crop;
    }

    public function calculateProperty($directory) {
        list($this->width, $this->height) = getimagesize(__DIR__ . '/../uploads/' . $directory . '/' . $this->name);

        if ($this->maxWidth == '' || $this->maxWidth > $this->width) $this->maxWidth = $this->width;
        if ($this->maxHeight == '' || $this->maxHeight > $this->height) $this->maxHeight = $this->height;

        if ($this->crop) {
            $cropRatioX = $this->maxWidth / $this->width;
            $cropRatioY = $this->maxHeight / $this->height;
            $cropRatio = max(array($cropRatioX, $cropRatioY));

            $this->newWidth = round($this->width * $cropRatio);
            $this->newHeight = round($this->height * $cropRatio);

            $this->cropX = ($this->newWidth > $this->newHeight) ? ($this->newWidth - $this->maxWidth) / 2 : 0;
            $this->cropY = ($this->newHeight > $this->newWidth) ? ($this->newWidth - $this->maxWidth) / 2 : 0;

            $this->x = ($this->maxWidth > $this->maxHeight) ? ($this->cropX / 2) * (-1) : 0;
            $this->y = ($this->maxHeight > $this->maxWidth) ? ($this->cropY / 2) * (-1) : 0;

            $this->newWidth_p = $this->maxWidth;
            $this->newHeight_p = $this->maxHeight;          
        } else {
            $ratioY = $this->maxWidth / $this->width;
            $ratioX = $this->maxHeight / $this->height;
            $ratio = min(array($ratioX, $ratioY));

            $this->newWidth = round($this->width * $ratio);
            $this->newHeight = round($this->height * $ratio); 

            $this->newWidth_p = $this->newWidth;
            $this->newHeight_p = $this->newHeight;              
        }

        $thumbnailName = 'thumbnail' . $this->newWidth_p . 'x' . $this->newHeight_p . '_' . $name;

        return array($newWidth_p, $newHeight_p, $thumbnailName);   
    }

    public function createThumbnail($thumbnailDirectory, $thumbnailName) {
        $image_p = imagecreatetruecolor($this->newWidth_p, $this->newHeight_p);
        $image = imagecreatefromjpeg(__DIR__ . '/../uploads/' . $directory . '/' . $this->name);

        imagecopyresampled($image_p, $image, $this->x, $this->y, $this->cropX, $this->cropY, $this->newWidth, $this->newHeight, $this->width, $this->height);

        imagejpeg($image_p, __DIR__ . '/../thumbnails/' . $thumbnailDirectory . '/' . $thumbnailName, 100);
    }
}
?>