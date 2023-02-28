<?php

namespace Eldia\Promise;

use ReflectionFunction;
use ReflectionMethod;


/**
 * @package Eldia
 * @author yassine benaid <yassinebenaide3@gmail.com>
 */



trait PromiseCallbacks
{

    /** call a callable instance */
    protected function call(callable $callback, ...$params)
    {
        return call_user_func($callback, ...$params);
    }


    /** get the first parameter type */
    protected function getFirstParatemerType(callable $callback): mixed
    {
        return $this->getParatemerTypes($callback)[0];
    }


    /** get all the parameter types */
    protected function getParatemerTypes(callable $callback): array
    {
        $reflector = $this->getReflector($callback);

        $types = [];

        foreach ($reflector->getParameters() as $parameter) {
            $types[] = $parameter->getType()?->getName();
        }


        return $types;
    }


    /** get the reflector for the given callable */
    protected function getReflector(callable $callback)
    {
        if (is_array($callback)) return new ReflectionMethod($callback[0], $callback[1]);

        return new ReflectionFunction($callback);
    }
}
