<?php

namespace Infernobass7\PrintNode;

class Printer extends Entity {
	protected $uri = 'printers';
	protected $foreignObjects = [
//		'computer' => Computer::class
	];

	public function print(PrintJob $job) {
		return $job->print($this);
	}

	public function getPrintJobs() {
		return collect($this->client->get("{$this->uri}/{$this->id}/printjobs"))->map(function($item) {
			return (new PrintJob())->setAttributes($item);
		});
	}

	public function getPrintJob($printJob) {
		if($printJob instanceof PrintJob) {
			$printJob = $printJob->id;
		}

		return (new PrintJob())->setAttributes($this->client->get("{$this->uri}/{$this->id}/printjobs/{$printJob}"));
	}

	public function getEmailAddress($key = 'id') {
		return "{$this->{$key}}@email.printnode.com";
	}
}