<?php

namespace Eldia\Promise;

/**
 * @package Eldia
 * @author yassine benaid <yassinebenaide3@gmail.com>
 */

class Promise
{
    use PromiseState,
        PromiseCallbacks,
        PromiseErrors;

    /** represent the recent promise's result */
    protected mixed $result = null;


    /** make new promise */
    public static function make(callable $executor): static
    {
        return new self($executor);
    }


    private function __construct(callable $executor)
    {
        $this->initState();

        $this->try(
            $executor,
            $this->fulfill(...),
            $this->reject(...)
        );
    }


    /** add fallbacks to promise */
    public function then(callable $onSuccess, callable $onFailure = null)
    {
        if ($this->hasError()) return $this;


        return new self(function ($success, $failure) use ($onSuccess, $onFailure) {

            if ($this->isFulfilled()) {
                $success($this->try($onSuccess, $this->result));
            } elseif ($this->isRejected() && $onFailure) {
                $failure($this->try($onFailure, $this->result));
            }
        });
    }

    /** mark the promise as fulfilled */
    private function fulfill($value = null)
    {
        if ($this->isPending()) {
            $this->fulfilled();
            $this->result = $value;
        }
    }

    /** mark the promise as rejected */
    private function reject($value = null)
    {
        if ($this->isPending()) {
            $this->rejected();
            $this->result = $value;
        }
    }


    /** catch errors occured inside the promise */
    public function catch(callable $callback)
    {
        if (!$this->hasError()) return $this;

        $exception_type = $this->getFirstParatemerType($callback);


        if ($exception_type && !$this->error instanceof $exception_type) return $this;


        $this->try($callback, $this->error);

        return $this;
    }


    /** try to execute callback and catch errors */
    private function try(callable $callback, ...$params)
    {
        try {
            return $this->call($callback, ...$params);
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
