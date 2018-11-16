<?php

use \PHPUnit\Framework\TestCase;
use \PhpX\Autoload\Autoloader;
use \PhpX\Autoload\IClassLocator;

class AutoloaderTest extends TestCase
{
	public function testGetLocator()
	{
		$locator = $this->createMock(IClassLocator::class);

		$autoloader = new Autoloader($locator);
		$this->assertSame($locator, $autoloader->getLocator());
	}

	public function testLoadClassDoesNotThrowWhenLocatorReturnsNull()
	{
		$testClass = 'NonexistentNamespace\\NonexistentClass';
		$this->assertFalse(\class_exists($testClass));

		$locator = $this->createMock(IClassLocator::class);
		$locator->method('getClassFile')
			->willReturn(null);

		$locator->expects($this->once())
			->method('getClassFile')
			->with($testClass);

		$autoloader = new Autoloader($locator);
		$autoloader->loadClass($testClass);
	}
	
	public function testLoadClassDoesNotThrowWhenLocatorReturnsNonexistentFile()
	{
		$testFile = '/xxxxxxxxxxxxxxxxxxxxxxxxxxxxx';
		$this->assertFileNotExists($testFile);

		$testClass = 'NonexistentNamespace\\NonexistentClass';
		$this->assertFalse(\class_exists($testClass));

		$locator = $this->createMock(IClassLocator::class);
		$locator->method('getClassFile')
			->willReturn($testFile);

		$locator->expects($this->once())
			->method('getClassFile')
			->with($testClass);


		$autoloader = new Autoloader($locator);
		$autoloader->loadClass($testClass);
	}

	public function testLoadsClassFromFileReturnedByLocator()
	{
		$testFile = __DIR__ . '/autoloader_test_class.php';
		$this->assertFileExists($testFile);

		$testClass = 'NonexistentNamespace\\NonexistentClass';
		$this->assertFalse(\class_exists($testClass));

		$locator = $this->createMock(IClassLocator::class);
		$locator->method('getClassFile')
			->willReturn($testFile);

		$locator->expects($this->once())
			->method('getClassFile')
			->with($testClass);
		
		$autoloader = new Autoloader($locator);
		$autoloader->loadClass($testClass);

		$this->assertTrue(\class_exists($testClass));
	}

	public function testRegister()
	{
		$testClass = 'NonexistentNamespace2\\NonexistentClass2';
		$this->assertFalse(\class_exists($testClass));

		$locator = $this->createMock(IClassLocator::class);
		$locator->method('getClassFile')
			->willReturn(null);

		$locator->expects($this->exactly(2))
			->method('getClassFile')
			->with($testClass);

		$autoloader = new Autoloader($locator);
		$autoloader->register();

		\class_exists($testClass);
		\class_exists($testClass);
	}

	public function testUnregister()
	{
		$testClass = 'NonexistentNamespace2\\NonexistentClass2';
		$this->assertFalse(\class_exists($testClass));

		$locator = $this->createMock(IClassLocator::class);
		$locator->method('getClassFile')
			->willReturn(null);

		$locator->expects($this->once())
			->method('getClassFile')
			->with($testClass);

		$autoloader = new Autoloader($locator);
		$autoloader->register();

		\class_exists($testClass);

		$autoloader->unregister();

		\class_exists($testClass);
	}
}
