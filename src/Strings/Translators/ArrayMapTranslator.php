<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\TranslatorInterface as Translator;
use ArrayAccess;

/**
 * Translates strings using an ArrayAccess for mapping.
 * Another translator is used as fallback.
 */
class ArrayMapTranslator implements Translator
{
    private $map;
    private $fallback;

    /**
     * @param ArrayAccess $map Map used to translate strings
     * @param Translator|null $fallback Another translator used if no mapping exists. Defaults to VoidTranslator.
     */
    public function __construct(ArrayAccess $map, Translator $fallback = null)
    {
        $this->map = $map;
        $this->fallback = $fallback ?: new VoidTranslator();
    }

    /**
     * {@inheritdoc}
     */
    public function translate(string $value): string
    {
        if (isset($this->map[$value])) {
            return $this->map[$value];
        }
        return $this->fallback->translate($value);
    }
}
