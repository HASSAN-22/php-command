## PHP command line

### Creating custom commands by PHP language With this package, you can easily create a command line script

## Install

```php
composer require hasan-22/php-console
```

## Usage:

Create a command
```php
use App\Console;

Console::command('command_name',function (){
    
})->purpose('Command description');

// purpose method is optional

// Run it like this
// php [scriptName.php] [command_name] [args]
```
---
Get input from user
```php
Console::command('get_username',function (){
    $input = Console::input('Enter your name: ');
    echo $input;
})->purpose('This command gets the username');

// Run:
// php script.php get_username
```
---
Secret input
```php
Console::command('get_password',function (){
    $input = Console::secretInput('Enter your password:');
    echo $input;
});

// Run:
// php script.php get_password
```
---

Get arguments for command line
```php
Console::command('get_password',function (){
    $input = Console::option('--pass');
    echo $input;
});
// Run:
// php script.php get_password --pass 123456

// Output: 123456

##################### OR ########################
Console::command('get_password',function (){
    $input = Console::option('pass');
    echo $input;
});
// Run:
// php script.php get_password pass 123456

// Output: 123456

##################### OR ########################
Console::command('get_password',function (){
    $input = Console::option('pass');
    echo $input;
});
// Run:
// php script.php get_password pass=123456

// Output: 123456


```

---

Add color to text
```php
Console::command('get_password',function (){
    $input = Console::option('--pass');
    echo Console::success($input);
    echo Console::error($input);
    echo Console::warning($input);
    echo Console::info($input);
    echo Console::none($input);
});
```
---

Help about commands
```php
// script.php help
// or
//script.php --help
// or
//script.php -h
// or
//script.php h
```

---

## Functions
| Functions | Description                                                        |                 Example                 |
|-----------|:-------------------------------------------------------------------|:---------------------------------------:|
| Command   | Create a command                                                   | Console::Command('commandName',Closure) |
| input     | It takes an input from the user and returns the value of the input |     Console::input('Your message')      |
| secretInput    | User input will not be visible to them as they type in the console         | Console::secretInput('You password: ')  |
| purpose   | Add a description to the command                                   |     Console::purpose('Description')     |
| option    | Takes the value of an argument                                     |       Console::option('argName')        |
