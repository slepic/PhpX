<?php

namespace PhpX\Strings;

/**
 * Interface for objects that can translate strings into different strings using any rules they wish.
 */
interface TranslatorInterface
{
	/**
	 * Translate a string into another string.
	 */
	public function translate(string $value): string;
}
