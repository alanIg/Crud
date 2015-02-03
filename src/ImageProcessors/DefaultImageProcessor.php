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
	public $path;
	public $thumbPrefix = 'n_';


	function __construct($maxWidth, $maxHeight, $maxThumbWidth, $maxThumbHeight, $path) {
		$this->maxWidth = $maxWidth;
		$this->maxHeight = $maxHeight;
		$this->maxThumbWidth = $maxThumbWidth;
		$this->maxThumbHeight = $maxThumbHeight;
		$this->path = $path;
	}

	public function process(\Nette\Image $image, $name) {
		try {
			$image->resize($this->maxWidth, $this->maxHeight, $this->resizeStrategy);
			$image->save($this->path . $name);
			if ($this->maxThumbHeight !== null) {
				$image->resize($this->maxThumbWidth, $this->maxThumbHeight, $this->resizeStrategy);
				$image->save($this->path . $this->thumbPrefix . $name);
			}
		} catch (Exception $exc) {
			throw $exc;
		}

		return true;
	}
	
	protected function getResizeStrategy(){
		return \Nette\Image::FIT;
	}

}

?>
