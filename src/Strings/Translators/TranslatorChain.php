<?php

namespace PhpX\Strings\Tranlators;

/**
 * Wraps an iterator of translators.
 * Feeds the to-be-translated value to the first translator, then the output to the next one,
 * and so on until all translators are called and the final result is returned.
 */
class TranslatorChain implements Translator
{
	private $chain;

	public function __construct(iterable $chain)
	{
		$this->chain = $chain;
	}

	public function translate(string $value): string
	{
		foreach($this->chain as $translator) {
			$value = $translator->translate($value);
		}
		return $value;
	}
}

