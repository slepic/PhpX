<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\Translators\EmptyTranslator;
use PHPUnit\Framework\TestCase;

class EmptyTranslatorTest extends TestCase
{
	public function testReturnsEmptyString()
	{
		$translator = new EmptyTranslator();

		$data = [
			'a' => '',
			'adajda' => '',
			'214325FDSFJPAO' => '',
			\md5(\time()) => '',
		];

		foreach ($data as $key => $expect) {
			$value = $translator->translate($key);
			$this->assertSame($expect, $value);
		}
	}
}
