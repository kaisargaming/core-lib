# PHP Core Library

> PHP Core library for Kaisargaming App Development.

The collection of classes is to be used as a library in to an app development setup with PHP and MySQL Stack.

## Installation

Use composer to install this library.

``` bash
$ composer require https://github.com/kaisargaming/lib-core.git
```

## Model

`Model` is the base class for implementing a simple MySQL abstraction layer which provides basic CRUD method for MVC development. Most of the method of this base class which will be available upon extending are made chainable to provide an easy to read code flow.

Example of extending `Model` base class.

``` php
<?php
class User extends Model
{
    public function __construct()
    {
        // Construct the parent class with the table name
        // and optionally the name of the primary key field
        // the primary key is default to 'id'
        parent::__construct('users', 'uid');
    }
}
```
The above simple class definition will provides required functionaly to communicate with `users` table.

``` php
<?php

$users = new User();

// Find all users
$all_users = $users->find()->fetch();
// Find users with conditions
$male_users = $users->find()->where("`sex`='male' AND `age`>27")->fetch();
// Create a new user
// use ->update() for update
$users->set('name', 'John')
    ->set('age', 32)
    ->set('sex', 'male')
    ->save();
```

## Utils

Utilities class should consists of static methods for ease of use during implementation.

```php
<?php
// Get a formatted time with a specific timezone
Utils::getTime('Y-m-d H:i:s', 'Asia/Hong_Kong');

```
