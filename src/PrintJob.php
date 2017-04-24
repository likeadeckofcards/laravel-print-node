<?php

namespace Infernobass7\PrintNode;

use PrintNode\Printer;

class PrintJob {
	private $printJob;

	public function __construct(Printer $printer = null, $content) {
		$this->printJob = new \PrintNode\PrintJob();

		if($printer) {
			$this->printJob->printer = $printer;
		}

		$this->printJob->contentType = 'pdf_base64';
		$this->printJob->content = base64_encode(file_get_contents($content));
		$this->printJob->source = 'My App/1.0';
		$this->printJob->title = 'Test';
	}

	public function print() {
		$request = new Request();

		return $request->post($this->printJob);
	}
}