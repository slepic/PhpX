<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\Translators\VoidTranslator;
use PHPUnit\Framework\TestCase;

class VoidTranslatorTest extends TestCase
{
	public function testReturnsSameString()
	{
		$translator = new VoidTranslator();

		$data = [
			'a',
			'adajda',
			'214325FDSFJPAO',
			\md5(\time()),
		];

		foreach ($data as $expect) {
			$value = $translator->translate($expect);
			$this->assertSame($expect, $value);
		}
	}
}
