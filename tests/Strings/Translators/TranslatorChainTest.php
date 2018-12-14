<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\Translators\TranslatorChain;
use PhpX\Strings\TranslatorInterface as Translator;
use PHPUnit\Framework\TestCase;

class TranslatorChainTest extends TestCase
{
	public function testReturnsEmptyString()
	{
		$hash = \md5(\time());
		$hash2 = \md5($hash);
		$hash3 = \md5($hash2);
		$translator1 = $this->createMock(Translator::class);
		$translator1->method('translate')
			->with($hash)
			->willReturn($hash . $hash2);
		$translator1->expects($this->once())
			->method('translate')
			->with($hash);
		$translator2 = $this->createMock(Translator::class);
		$translator2->method('translate')
			->with($hash . $hash2)
			->willReturn($hash . $hash2 . $hash3);
		$translator2->expects($this->once())
			->method('translate')
			->with($hash . $hash2);

		$chain = new TranslatorChain([
			$translator1,
			$translator2,
		]);

		$result = $chain->translate($hash);
		$this->assertSame($hash . $hash2 . $hash3, $result);
	}
}
