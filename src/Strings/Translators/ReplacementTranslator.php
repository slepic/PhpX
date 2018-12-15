<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\TranslatorInterface as Translator;
use str_replace;

/**
 * Translate string using str_replace passing the to-be-translated value as the replacement argument.
 *
 * Example:
 * (new ReplacementTranslator('Hello, #.', '#'))->translate('Peter');
 * yields "Hello, Peter."
 */
final class ReplacementTranslator implements Translator
{
    private $subject;
    private $needle;

    public function __construct(string $subject, string $needle)
    {
        $this->subject = $subject;
        $this->needle = $needle;
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $value): string
    {
        return str_replace($this->needle, $value, $this->subject);
    }
}
