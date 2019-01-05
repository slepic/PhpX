<?php

namespace PhpX\TypeHint;

use \Exception;

/**
 * Use this exception to indicate type mismatch error.
 *
 * The expected type and value given are the only required parameters for its constructor.
 * The exception automaticaly appends a message stating which type was expected and which was given.
 */
class InvalidTypeException extends Exception
{
    /**
     * @var string
     */
    private $expectedType;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var string|null
     */
    private $additionalMessage;

    /**
     * @param string|iterable<string> $expectedType
     * @param mixed $value
     * @param string|null $additionalMessage
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($expectedType, $value, ?string $additionalMessage = null, $code = 0, \Exception $previous = null)
    {
        if (!\is_string($expectedType)) {
            if ($expectedType instanceof \Traversable) {
                $expectedType = \iterator_to_array($expectedType);
            }
            if (\is_array($expectedType)) {
                $expectedType = \implode('|', $expectedType);
            }
            if (!\is_string($expectedType)) {
                throw new self('string|iterable<string>', $expectedType, null, 0, $previous);
            }
        }
        if ($additionalMessage !== null && !\is_string($additionalMessage)) {
            throw new self('string|null', $expectedType, null, 0, $previous);
        }
        $this->expectedType = $expectedType;
        $this->value = $value;
        $this->additionalMessage = $additionalMessage;
        $message = $this->generateMessage();
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getExpectedType(): string
    {
        return $this->expectedType;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getAdditionalMessage(): ?string
    {
        return $this->additionalMessage;
    }

    /**
     * @return string
     */
    public function getRealType(): string
    {
        if (\is_object($this->value)) {
            return \get_class($this->value);
        }
        return \gettype($this->value);
    }

    /**
     * @return string
     */
    private function generateMessage(): string
    {
        $realType = $this->getRealType();
        $message = "Expected '{$this->expectedType}', got '{$realType}'.";
        if ($this->additionalMessage !== null) {
            return $message . ' ' . $this->additionalMessage;
        }
        return $message;
    }
}
