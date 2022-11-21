# ToDoList

    Base du projet #8 : Améliorez un projet existant
    https://openclassrooms.com/projects/ameliorer-un-projet-existant-1 Package

**P8_ToDoList Upgraded by ChunCheungDuret**

## About the Project

    ToDolist it's an application builded by PHP framework Symfony with version 3.1,
    but this version is no longer maintained , so the application needs to upgrade.

### This project needs

- Implementation more new features to perpetuatethe development of
  theapplication.

- Make an inventory of the application's technical Produce a code audit on
  following code quality and performance.

## Application upgraded to :

- PHP 8.1
- Composer
- Symfony 6.1

## Requirements

        PHP >= 8.1
        Web server
        Composer >= 2.3.10
        Symfony >= 6.1
        Mysql >= 5.7.24`
        phpunit = 9

## Installation

- Installation and Configuration for web server. Here I'm using MAMP
  [MAMP](https://www.mamp.info/en/downloads/)

- Clone the repo [ProjetRepo](https://github.com/rachel-duret/ToDoList.git)

- Install [Symfony](https://symfony.com/doc/current/setup.html)
- Get into your project directory start your web server -Install libraries
- composer install
- Set up the database
- Create .env.local file following .env file to configure the appropriates
  values

### To run the test

`To run all the test following the command:`

      vendor/bin/phpunit

`To run a sigle test following the command:`

      vendor/bin/phpunit --filter=<methodName>

`To generate coverage of test following the command:`

      vendor/bin/phpunit --coverage-html public/test-coverage

[ Phpunit documentation ](https://phpunit.de/documentation.html)
[ Symfony test](https://symfony.com/doc/current/testing.html)

### Demo data

`To Add some demo data run command :`

     php bin/console doctrine:fixtures:load

### Authors

[@RachelDuret](https://github.com/rachel-duret)

### Badges

[Codacy](https://app.codacy.com/gh/rachel-duret/ToDoList/dashboard?branch=main)

<style>
    h1{
        color: #043959;
    },

    h2{
        color: #135e96 ;
    },

    p{
        background: #dcdcde;
    }
</style>
