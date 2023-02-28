<?php

namespace Eldia\Promise;

use Throwable;


/**
 * @package Eldia
 * @author yassine benaid <yassinebenaide3@gmail.com>
 */


trait PromiseErrors
{
    protected ?Throwable $error = null;


    /** determine wether the promise has error or not */
    protected function hasError(): bool
    {
        return !is_null($this->error);
    }


    /** add throwable error */
    protected function error(Throwable $error)
    {
        $this->error = $error;
    }
}
