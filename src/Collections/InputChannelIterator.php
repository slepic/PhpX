<?php

namespace PhpX\Collections;

use Iterator;

/**
 * Adapts an InputChannelInterface to an Iterator.
 *
 * @generic InputChannelIterator<ValueType> implements Iterator<int, ValueType>
 *
 * Iterating this iterator has destructive effect on the contents of the input channel.
 * Once the iterator is iterated to the end, the channel is empty.
 * Once the channel is inserted with new items, the iterator becomes valid right away.
 *
 * Keys of the iterator are just a "by one" incremental sequence starting with zero and counting iterated items.
 *
 * Rewinding this iterator has no effect, except it resets the current key to zero,
 * but the actual current item remains the same.
 *
 * @tip The following results in an interesting iterator:
 *
 * $i = new InputChannelIterator(new IteratorInputChannel($iterator));
 *
 * It then behaves similar to native PHP NoRewindIterator, except two things:
 * 1) it can be rewound, but if you do it, it remains invalid
 * and does not iterate any items anymore until the original iterator is rewound.
 * 2) It changes keys to incremental integer sequence, because it looses track
 * of the orginal keys because of the channel in the middle.
 *
 * @todo Decorate channel
 */
class InputChannelIterator implements Iterator
{
    /**
     * @var InputChannelInterface
     */
    private $channel;

    /**
     * @var int
     */
    private $position = 0;

    /**
     * @param InputChannelInterface<ValueType> $channel
     */
    public function __construct(InputChannelInterface $channel)
    {
        $this->channel = $channel;
    }

    /**
     * Get the underlying channel.
     *
     * @return InputChannelInterface
     */
    public function getChannel(): InputChannelInterface
    {
        return $this->channel;
    }

    /**
     * Sets current key to zero.
     *
     * The validity and current item remain the same.
     *
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->position = 0;
    }

    /**
     * Iterator is valid if channel is not empty.
     *
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return false === $this->channel->isEmpty();
    }

    /**
     * Extracts the top of the channel and increases current key by one.
     *
     * {@inheritdoc}
     */
    public function next(): void
    {
        ++$this->position;
        $this->channel->extract();
    }

    /**
     * Returns zero based offset from the last call to rewind.
     *
     * {@inheritdoc}
     */
    public function key(): int
    {
        return $this->position;
    }

    /**
     * Returns current top of the channel.
     *
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->channel->top();
    }
}
