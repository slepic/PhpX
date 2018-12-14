<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\TranslatorInterface as Translator;

/**
 * Wraps an iterator of translators.
 * Feeds the to-be-translated value to the first translator, then the output to the next one,
 * and so on until all translators are called and the final result is returned.
 *
 * Generic form if generic Translator<SourceType, TargetType> is introduced:
 * TranslatorChain<ValueType> implements Translator<ValueType, ValueType>
 * {
 * 	private iterable<T extends Translator<ValueType, ValueType>> $chain
 * }
 */
class TranslatorChain implements Translator
{
	/**
	 * @var iterable<T extends Translator>
	 */
	private $chain;

	/**
	 * @param iterable<T extends Translator> $chain
	 */
	public function __construct(iterable $chain)
	{
		$this->chain = $chain;
	}

	/**
	 * {@inheritdoc}
	 */
	public function translate(string $value): string
	{
		foreach ($this->chain as $translator) {
			$value = $translator->translate($value);
		}
		return $value;
	}
}

