<?php

namespace Eldia\Promise;


/**
 * @package Eldia
 * @author yassine benaid <yassinebenaide3@gmail.com>
 */


trait PromiseState
{
    protected readonly string $PENDING;
    protected readonly string $FULFILLED;
    protected readonly string $REJECTED;

    /**
     * holds the current promise state
     *
     * @var string
     */
    protected string $state;


    /**
     * initial stats values
     */
    protected function initState(): void
    {
        $this->PENDING = 'pending';
        $this->FULFILLED = 'fulfilled';
        $this->REJECTED = 'rejected';

        $this->pending();
    }

    /** determine wether the promise still pending */
    protected function isPending(): bool
    {
        return $this->state === $this->PENDING;
    }

    /** determine wether the promise was fulfilled */
    protected function isFulfilled(): bool
    {
        return $this->state === $this->FULFILLED;
    }

    /** determine wether the promise was rejected */
    protected function isRejected(): bool
    {
        return $this->state === $this->REJECTED;
    }

    /** set the promise state to pending */
    protected function pending(): void
    {
        $this->state = $this->PENDING;
    }

    /** set the promise state to fulfilled */
    protected function fulfilled(): void
    {
        $this->state = $this->FULFILLED;
    }

    /** set the promise state to rejected */
    protected function rejected(): void
    {
        $this->state = $this->REJECTED;
    }
}
