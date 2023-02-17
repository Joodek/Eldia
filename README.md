# Eldia
Eldia is a lightweight PHP package that provides developers with a set of extra helpers
to simplify common programming tasks. The library is designed to be easy to use, with an
elegant and intuitive syntax that makes it easy to add powerful functionality to your PHP applications.

The Eldia package includes a variety of helpers that can be used for tasks like working with arrays,
manipulating strings, generating random data, dealing with exceptions and more. These helpers are designed to be easy to integrate 
into your code, and they can help you to write cleaner, more efficient PHP code.

## installation 
```
    composer require yassinebenaid/eldia
```

## Features

#### Promises

have you used Javascript promises, if so , then you probably liked the functionality they give , 
    and how great they are . now you can use them in php like this :
    
     Promise::make(function ($success, $reject) {

            if (0) {
                $success('hello world');
            } else {
                $reject('error');
            }
        })

            ->then(fn ($message) => print($message), fn ($reason) => print($reason))

            ->catch(fn ($exception) => print($exception->getMessage()));
