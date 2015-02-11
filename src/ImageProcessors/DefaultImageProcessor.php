<?php

namespace TomasVodrazka\Crud\ImageProcessors;

/**
 * Description of PhotoProcessor
 *
 * @author TomU
 */
class DefaultImageProcessor implements IImageProcessor {

	public $maxWidth;
	public $maxHeight;
	public $maxThumbWidth;
	public $maxThumbHeight;
	public $fullPath;
	public $publicPath;
	public $thumbPrefix;

	function __construct($maxWidth, $maxHeight, $maxThumbWidth, $maxThumbHeight, $fullPath, $publicPath, $thumbPrefix = 'n_') {
		$this->maxWidth = $maxWidth;
		$this->maxHeight = $maxHeight;
		$this->maxThumbWidth = $maxThumbWidth;
		$this->maxThumbHeight = $maxThumbHeight;
		$this->fullPath = $fullPath;
		$this->publicPath = $publicPath;
		$this->thumbPrefix = $thumbPrefix;
	}

	public function process(\Nette\Image $image, $name) {
		try {
			$image->resize($this->maxWidth, $this->maxHeight, $this->getResizeStrategy());
			$image->save($this->fullPath . $name);
			if ($this->maxThumbHeight !== null) {
				$image->resize($this->maxThumbWidth, $this->maxThumbHeight, $this->getResizeStrategy());
				$image->save($this->fullPath . $this->thumbPrefix . $name);
			}
		} catch (Exception $exc) {
			throw $exc;
		}

		return true;
	}

	public function delete($name) {
		if (is_file($this->fullPath . $name)) {
			unlink($this->fullPath . $name);
			return true;
		}
		return false;
	}

	protected function getResizeStrategy() {
		return \Nette\Image::FIT;
	}

}

?>
