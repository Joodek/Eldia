<?php

namespace Eldia\Promise;


use Exception;

final class Promise
{
    const PENDING = 'pending';
    const FULFILLED = 'fulfilled';
    const REJECTED = 'rejected';

    private $state = self::PENDING;
    private $result = null;
    private $callbacks = [];


    private function __construct(callable $executor)
    {
        $resolve = function ($value) {
            $this->fulfill($value);
        };
        $reject = function ($reason) {
            $this->reject($reason);
        };
        try {
            $executor($resolve, $reject);
        } catch (Exception $e) {
            $this->reject($e);
        }
    }

    public static function make(callable $executer)
    {
        return new self($executer);
    }

    public function then(callable $onFulfilled = null, callable $onRejected = null)
    {
        $promise = new self(function ($resolve, $reject) use ($onFulfilled, $onRejected) {
            $callback = function () use ($resolve, $reject, $onFulfilled, $onRejected) {
                try {
                    if ($this->state == self::FULFILLED) {
                        if (is_callable($onFulfilled)) {
                            $result = $onFulfilled($this->result);
                            if ($result instanceof self) {
                                $result->then($resolve, $reject);
                                return;
                            }
                            $resolve($result);
                        } else {
                            $resolve($this->result);
                        }
                    } else if ($this->state == self::REJECTED) {
                        if (is_callable($onRejected)) {
                            $result = $onRejected($this->result);
                            if ($result instanceof self) {
                                $result->then($resolve, $reject);
                                return;
                            }
                            $resolve($result);
                        } else {
                            $reject($this->result);
                        }
                    }
                } catch (Exception $e) {
                    $reject($e);
                }
            };
            if ($this->state == self::PENDING) {
                $this->callbacks[] = $callback;
            } else {
                $callback();
            }
        });
        return $promise;
    }


    public function catch(callable $onRejected)
    {
        return $this->then(null, $onRejected);
    }


    private function fulfill($value)
    {
        if ($this->state == self::PENDING) {
            $this->state = self::FULFILLED;
            $this->result = $value;
            $this->callCallbacks();
        }
    }


    private function reject($reason)
    {
        if ($this->state == self::PENDING) {
            $this->state = self::REJECTED;
            $this->result = $reason;
            $this->callCallbacks();
        }
    }


    private function callCallbacks()
    {
        foreach ($this->callbacks as $callback) {
            $callback();
        }
        $this->callbacks = [];
    }
}
