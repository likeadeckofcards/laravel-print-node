<?php

namespace Infernobass7\PrintNode;

use PrintNode\ApiKey;
use PrintNode\Credentials;
use PrintNode\Entity;

class Request {
	private $credentials;
	private $request;

	public function __construct(string $apiKey = '', string $email = '', string $password = '', array $endPointUrls = array(), array $methodNameEntityMap = array(), $offset = 0, $limit = 10) {
		$this->credentials = new Credentials();
		if(! empty($apiKey) || config('printnode.auth.key')) {
			$this->credentials->setApiKey($apiKey ?: config('printnode.auth.key'));
		} else if((! empty($email) || config('printnode.auth.email')) && (! empty($password) || config('printnode.auth.password'))) {
			$this->credentials->setEmailPassword($email ?: config('printnode.auth.email'),$password ?: config('printnode.auth.password'));
		} else {
			throw new AuthenticationException("No valid authentication methods provided.");
		}

		$this->request = new \PrintNode\Request($this->credentials, $endPointUrls, $methodNameEntityMap, $offset, $limit);
	}

	/**
	 * DELETE (delete) the specified entity
	 * @param \PrintNode\Entity $entity
	 * @return \PrintNode\Response
	 */
	public function delete(Entity $entity)
	{
		return $this->request->delete($entity);
	}

	/**
	 * Delete a child account
	 * MUST have $this->childauth set to run.
	 * @return \PrintNode\Response
	 * */
	public function deleteAccount()
	{
		return $this->request->deleteAccount();
	}

	/**
	 * Delete an ApiKey for a child account
	 * @param string $apikey
	 * @return \PrintNode\Response
	 * */
	public function deleteApiKey($apikey)
	{
		return $this->deleteApiKey($apikey);
	}

	/**
	 * Delete a tag for a child account
	 * @param string $tag
	 * @return \PrintNode\Response
	 * */
	public function deleteTag($tag)
	{
		return $this->request->deleteTag($tag);
	}

	/**
	 * Returns a client key.
	 * @param string $uuid
	 * @param string $edition
	 * @param string $version
	 * @return \PrintNode\Response
	 * */
	public function getClientKey($uuid, $edition, $version)
	{
		return $this->request->getClientKey($uuid, $edition, $version);
	}

	/**
	 * Get all printers.
	 * @return Entity[]
	 * */
	public function getPrinters()
	{
		return collect($this->request->getPrinters())->filter();
	}

	/**
	 * Get all printers.
	 * @return Entity[]
	 * */
	public function getPrinterByName($name)
	{
		return collect($this->request->getPrinters())->filter(function($printer) use ($name) {
			return $printer->name == $name;
		})->first();
	}

	/**
	 * Get printers relative to a computer.
	 * @param string $computerIdSet set of computer ids to find printers relative to
	 * @param string $printerIdSet OPTIONAL: set of printer ids only found in the set of computers.
	 * @return Entity[]
	 * */
	public function getPrintersByComputers()
	{
		return $this->request->getPrintersByComputers();
	}

	/**
	 * Gets PrintJobs relative to a printer.
	 * @param string $printerIdSet set of printer ids to find PrintJobs relative to
	 * @param string $printJobId OPTIONAL: set of PrintJob ids relative to the printer.
	 * @return Entity[]
	 * */
	public function getPrintJobsByPrinters()
	{
		return $this->request->getPrintJobsByPrinters();
	}

	/**
	 * Gets print job states.
	 * @param string $printjobId OPTIONAL:if unset gives states relative to all printjobs.
	 * @return Entity[]
	 * */
	public function getPrintJobStates()
	{
		return $this->getPrintJobStates();
	}

	/**
	 * Gets scales relative to a computer.
	 * @param string $computerId id of computer to find scales
	 * @return Entity[]
	 * */
	public function getScales($computerId)
	{
		return $this->request->getScales($computerId);
	}

	/**
	 * PATCH (update) the specified entity
	 * @param Entity $entity
	 * @return \PrintNode\Response
	 * */
	public function patch(Entity $entity)
	{
		return $this->request->patch($entity);
	}

	/**
	 * POST (create) the specified entity
	 * @param Entity $entity
	 * @return \PrintNode\Response
	 */
	public function post(Entity $entity)
	{
		return $this->request->post($entity);
	}

	/**
	 * PUT (update) the specified entity
	 * @param Entity $entity
	 * @return \PrintNode\Response
	 */
	public function put()
	{
		return $this->request->put();
	}

	public function setChildAccountById($id)
	{
		$this->request->setChildAccountById($id);
	}

	public function setChildAccountByEmail($email)
	{
		$this->request->setChildAccountByEmail($email);
	}

	public function setChildAccountByCreatorRef($creatorRef)
	{
		$this->request->setChildAccountByCreatorRef($creatorRef);
	}

	/**
	 * Set the limit for GET requests
	 * @param mixed $limit
	 */
	public function setLimit($limit)
	{
		$this->request->setLimit($limit);
	}

	/**
	 * Set the offset for GET requests
	 * @param mixed $offset
	 */
	public function setOffset($offset)
	{
		$this->request->setOffset($offset);
	}

	/**
	 * Map method names getComputers, getPrinters and getPrintJobs to entities
	 * @param mixed $methodName
	 * @param mixed $arguments
	 * @return Entity[]
	 */
	public function __call($methodName, $arguments)
	{
		return $this->request->__call($methodName, $arguments);
	}
}