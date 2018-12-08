<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\TranslatorInterface as Translator;

/**
 * Always translates to empty string.
 *
 * Useful as fallback translator.
 */
final class EmptyTranslator implements Translator
{
	/**
	 * {@inheritdoc}
	 */
	public function translate(string $value): string
	{
		return '';
	}
}
