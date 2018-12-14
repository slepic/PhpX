<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\Translators\ReplacementTranslator;
use PHPUnit\Framework\TestCase;

class ReplacementTranslatorTest extends TestCase
{
	public function testReturnsSameString()
	{
		$translator = new ReplacementTranslator('1#2#3', '#');

		$hash = \md5(\time());
		$data = [
			'a' => '1a2a3',
			'ab' => '1ab2ab3',
			$hash => '1' . $hash . '2' . $hash . '3',
		];

		foreach ($data as $key => $expect) {
			$value = $translator->translate($key);
			$this->assertSame($expect, $value);
		}
	}
}
