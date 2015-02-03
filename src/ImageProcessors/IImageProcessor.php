<?php

namespace TomasVodrazka\Crud\ImageProcessors;

/**
 *
 * @author TomU
 */
interface IImageProcessor {

	public function process(\Nette\Image $image, $name);
}

?>
