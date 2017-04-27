<?php

namespace Infernobass7\PrintNode;

use function GuzzleHttp\Psr7\str;

class Client {
	private $client;

	private $username = null;
	private $password = null;

	/**
	 * Map entity names to API URLs
	 * @var string[]
	 */
	private $endPointUrls = [
		'PrintNode\Client' => '/download/clients',
		'PrintNode\Download' => '/download/client',
		'PrintNode\ApiKey' => '/account/apikey',
		'PrintNode\Account' => '/account',
		'PrintNode\Tag' => '/account/tag',
		'PrintNode\Whoami' => '/whoami',
		'PrintNode\Computer' => '/computers',
		'PrintNode\Printer' => '/printers',
		'PrintNode\PrintJob' => '/printjobs',
	];

	/**
	 * Map method names used by __call to entity names
	 * @var string[]
	 */
	private $methodNameEntityMap = [
		'Clients' => 'PrintNode\Client',
		'Downloads' => 'PrintNode\Download',
		'ApiKeys' => 'PrintNode\ApiKey',
		'Account' => 'PrintNode\Account',
		'Tags' => 'PrintNode\Tag',
		'Whoami' => 'PrintNode\Whoami',
		'Computers' => 'PrintNode\Computer',
		'Printers' => 'PrintNode\Printer',
		'PrintJobs' => 'PrintNode\PrintJob',
	];

	public function __construct() {
		$this->client = new \GuzzleHttp\Client(['base_uri' => 'https://api.printnode.com']);
	}

	public function getAuthentication() {
		return [
			$this->getUsername(),
			$this->getPassword()
		];
	}

	public function setUsername($username) {
		$this->username = $username;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getUsername() {
		return $this->username ?: config("printnode.auth.username");
	}

	public function getPassword() {
		return$this->password ?: config("printnode.auth.password", '');
	}

	public function makeRequest($method, $uri, array $options = []) {
		if(! array_key_exists('auth', $options)) {
			$options['auth'] = $this->getAuthentication();
		}

		$options['headers'] = [
			'Accept-Encoding' => 'gzip,deflate',
			'Content-Type' => "application/json"
		];
		if(array_key_exists('json', $options) && array_key_exists('content', $options['json'])) {
			$options['headers']['Content-Type'] = strlen($options['json']['content']);
		}
		$options['verify'] = false;
		$options['allow_redirects'] = true;

		$response = $this->client->request($method,$uri,$options);

		return json_decode($response->getBody()->getContents(), true);
	}

	public function get($uri, $options = []) {
		return $this->makeRequest('GET', $uri, $options);
	}

	public function post($uri, $options = []) {
		return $this->makeRequest('POST', $uri, $options);
	}

	public function put($uri, $options = []) {
		return $this->makeRequest('PUT', $uri, $options);
	}

	public function delete($uri, $options = []) {
		return $this->makeRequest('DELETE', $uri, $options);
	}

	public function whoami() {
		return $this->makeRequest('GET', 'whoami');
	}
}