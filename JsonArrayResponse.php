<?php


namespace TomasVodrazka\Crud;

/**
 * Description of JsonArrayResponse
 *
 * @author tvodr_000
 */
class JsonArrayResponse implements \Nette\Application\IResponse {
	
	private $json;
	
	function __construct($json) {
		$this->json = $json;
	}

	
	public function send(\Nette\Http\IRequest $httpRequest, \Nette\Http\IResponse $httpResponse) {
		$httpResponse->setContentType('application/json');
		$httpResponse->setExpiration(FALSE);
        echo $this->json;
	}
}
