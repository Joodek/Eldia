# Eldia

<img style="width:100%;" src="https://preview.redd.it/2yua2b3r7bb71.png?width=640&crop=smart&auto=webp&s=8d1181f9108f0c98b3ec1f9c2c5c8341cd4d56a8"/>

Eldia is a lightweight PHP package that provides developers with a set of extra helpers
to simplify common programming tasks. The library is designed to be easy to use, with an
elegant and intuitive syntax that makes it easy to add powerful functionality to your PHP applications.

The Eldia package includes a variety of helpers that can be used for tasks like working with arrays,
manipulating strings, generating random data, dealing with exceptions and more. These helpers are designed to be easy to integrate 
into your code, and they can help you to write cleaner, more efficient PHP code.

## installation 
```
    composer require joodek/eldia
```

## Features

#### Promises

have you used Javascript promises, if so then you probably like them , I like them , now you can use them in php like this :
    
    
     use Eldia\Promise\Promise;
     
     Promise::make(function ($success, $reject) {

            if (0) {
                $success('hello world');
            } else {
                $reject('error');
            }
        })

            ->then(fn ($message) => print($message), fn ($reason) => print($reason))

            ->catch(fn ($exception) => print($exception->getMessage()));
            

you can use how many `then` you like , everytime you use it , you have access to the latest returned data , see example
    
    
    Promise::make(function ($success, $reject) {

        $var = 5 + 5;
  
        if ($var === 10) $success($var);
        else $reject($var);
    })
      ->then(fn ($data) => $data + 5)
      ->then(fn ($data) =>  print  $data) // 15
    
that's available in both , `success` and `reject` callbacks, and you can even avoid using the `reject` at all : 

    
     Promise::make(function ($success) {

            if (0) {
                $success('hello world');
            } else{
                // do somthing
            }
        })

            ->then(fn ($message) => print($message))


during the promise callbacks , you're safe from all types of errors , even the syntax errors , which means
that whatever happend in the callbacks, no error will occur , it will just stop executing the callbacks, 
but , for some reason you want to execute some code when an error occurs , you can use `catch` , 
    
     Promise::make(function ($success) {

            if (0) {
                $success('hello world');
            } else{
                throw new Exception('error');
            }
        })

            ->catch(fn ($exception) => print($exception->getMessage())) // prints "error"

you can even catch specific error by just typing hint the exception type , 
typed exception will only be exceuted  if it matches the type : 


     Promise::make(function ($success) {

        $str = "baz";

        if ($str === "foo") {
            $success('hello world');
        } else {
            throw new ValidationException('error');
        }
    })

        ->catch(fn (AuthException $exception) => print($exception->getMessage())) // won't works
        ->catch(fn (ValidationException $exception) => print($exception->getMessage())); // prints "error"
