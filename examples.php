<?php

require_once __DIR__ . '/ServiceLocator.php';

/**
 * Shows various examples how to create services on derived class of ServiceLocator
 */
class TestLocator
extends ServiceLocator
{
	function createServiceTest() {
		return 'test';
	}

	function createServiceRepositoryLocatorA() {
		return new RepositoryLocatorA();
	}

	function createServiceRepositoryLocatorB() {
		return new RepositoryLocatorB();
	}

	function createService($id) {
		$service = parent::createService($id);
		if($service === null) {
			$matches = [];
			if(\preg_match('/UserRepository([ABC])/', $id, $matches)) {
				$service = $this->getService('RepositoryLocator'.$matches[1])->getService('user');
			}
		}
		return $service;
	}

	function createServiceRepositoryLocators() {
		return [
			$this->getService('RepositoryLocatorA'), 
			$this->getService('RepositoryLocatorB'),
			$this->getService('RepositoryLocatorC')
		];
	}

	function createServiceUserRepositories() {
		$service = [];
		foreach(['A', 'B', 'C'] as $x) {
			$service[$x] = $this->getService('UserRepository' . $x);
		}
		return $service;
	}
}

/**
 * Example class to play with
 */
class Repository
{
	private $tableName;

	function __construct($tableName) {
		$this->setTableName($tableName);
	}

	function getTableName() {
		return $this->tableName;
	}

	function setTableName($tableName) {
		$this->tableName = $tableName;
	}
}
// SOME MORE examples how to create services and we can use these
// to make some hierarchy by placing more service locators in a tree structure

class RepositoryLocatorA
extends ServiceLocator
{
	function createService($id) {
		return new Repository($id);
	}
}

class RepositoryLocatorB
extends ServiceLocator
{
	function createServiceUser($id) {
		return new Repository('special_' . $id . '_table');
	}
}

class RepositoryLocatorC
extends ServiceLocator
{
	function getFactoryMethodName($id) {
		$method = 'create' . $id . 'Repository';
		if(\method_exists($this, $method)) {
			return $method;
		}
		return parent::getServiceFactoryMethodName($id);
	}

	function createUserRepository() {
		return new Repository('special_user_table');
	}

	static function getInstance() {
		return new self();
	}
}



//lets instantiate our test locator
$sl = new TestLocator();

//and start getting the services we declared factories for
$sl->getService('Test');

$sl->setFactory('FactoredService', function () {
	return 'Accessing hasService is enough to instantiate the service FactoredService';
});
$sl->hasService('FactoredService');

$sl->setFactory('RepositoryLocatorC', ['RepositoryLocatorC', 'getInstance']);

$rls = $sl->getService('RepositoryLocators');
\array_walk($rls, function ($rl) {
	$rl->getService('user');
});

$sl->getService('UserRepositories');

//finally lets print the structure of the main service locator
//to see that all is loaded and ready to be retrieved again for new DI using objects
\print_r($sl);


