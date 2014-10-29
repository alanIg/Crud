<?php

namespace TomasVodrazka\Crud\Tables;

/**
 * Description of AngularTableButton
 *
 * @author tvodr_000
 */
class AngularTableButton {

	private $linkPattern;
	private $text;
	private $icon;
	private $class = array('btn', 'btn-xs');
	
	private $classImp;
	

	function __construct($text, $icon = null, $class = array(), $btnStyle = 'btn-default') {
		$this->text = $text;
		$this->icon = $icon;
		$this->addClass($btnStyle);
		$this->addClass($class);
		
	}

	private function addClass($class) {
		if (is_array($class)) {
			foreach ($class as $value) {
				$this->class[] = $value;
			}
		} else {
			$this->class[] = $class;
		}
	}
	
	public function setLinkPattern($linkPattern) {
		$this->linkPattern = $linkPattern;
	}

	public function getClass() {
		if ($this->classImp == null) {
			$this->classImp = implode(' ', $this->class);
		}
		return $this->classImp;
	}

	public function getHtml($id) {
		$html = "<a href='" . $this->getLink($id) . "' class='" . implode(' ', $this->class) . "'>";
		if ($this->icon != null) {
			$html .= "<i class='fa fa-$this->icon'></i>";
		}
		$html .= $this->text . "</a>";
		return $html;
	}

	public function getLink($id) {
		return preg_replace("@_ID_@", $id, $this->linkPattern);
	}

	public function getArray($id) {
		return array('link' => $this->getLink($id), 'text' => $this->text, 'class' => $this->getClass(), 'icon' => $this->icon);
	}

}
