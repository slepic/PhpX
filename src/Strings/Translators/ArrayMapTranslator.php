<?php

namespace PhpX\Strings\Translators;

use PhpX\Strings\TranslatorInterface as Translator;
use ArrayAccess;
use ArrayObject;

/**
 * Translates strings using an ArrayAccess for mapping.
 * Another translator is used as fallback.
 */
class ArrayMapTranslator implements Translator
{
    private $map;
    private $fallback;

    /**
     * @param ArrayAccess|null $map Map used to translate strings
     * @param Translator|null $fallback Another translator used if no mapping exists. Defaults to VoidTranslator.
     */
    public function __construct(ArrayAccess $map = null, Translator $fallback = null)
    {
        $this->map = $map ?: new ArrayObject();
        $this->fallback = $fallback ?: new VoidTranslator();
    }

    public function getMap(): ArrayAccess
    {
        return $this->map;
    }

    public function getFallback()
    {
        return $this->fallback;
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
