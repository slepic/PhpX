<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\TranslatorInterface as Translator;

/**
 * Makes no translation at all.
 *
 * Good to pass to components that require translator but you wish to do no translations.
 * Also useful as fallback translator.
 */
final class VoidTranslator implements Translator
{
	/**
	 * {@inheritdoc}
	 */
	public function translate(string $value): string
	{
		return $value;
	}
}
