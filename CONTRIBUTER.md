# Open Classrooms project 8 ToDo&Co.

Created by Chun Cheung Duret at 17/11/2022

---

## How to contribute

Enhance an existing Symfony application from ToDo&Co. This is an application to
manage daily tasks. Following the steps below to contribute the project :

### Step 1: Setup technical Requirements

` Before contributer this project you must:`

- Install PHP 8.1 or higher PHP extensions.

- Install Composer, which is used to install PHP packages.

### Step 2: Get the github repository

- Go to ToDoList github repository <https://github.com/rachel-duret/ToDoList> on
  the top right of the page by clicking the button **Fork** to create a new
  fork.

* Clone the project following the command:

```
        git clone https://github.com/rachel-duret/ToDoList.git
```

`Or simplement downloas ZIP file`

- To run the project by following README.md file

* Add the original ToDoList repository as a "git remote" called upstream.

        The remote repository on your GitHub and called "origin".
         At this point, if you want to keep your fork in sync with the toDoList forked repository, you need to configure "git remote" that points to the original project so that you can retrieve the changes and import them  into your local copy.

> Run the command to add `Upstream remote `:

```
    git remote add upstream https://github.com/rachel-duret/ToDoList.git
```

> To check your remotes run command :

        git remote -v

If you add `Upstream` remote to your repository you have two **remotes** for
this project:

    1. Origin, which points to your github repository of the project . You have teh right to write .

    2. Upstream, which points to the github repository of the current project. You do not have the right to write.

> Retrieve all commits from the upstream branches by running the command:

     git fetch upstream

The purpose of this step is to allow you to work simultaneously on the official
ToDoList repository and on your own fork.

### Step 3: Work on the project:

> - Run the project by following the README.md file.
> - Navigate to you project directory.
> - Create a new branch. Using a short, remenberable name for this branch.
> - Push your new branch to you repository.

### Step 4: Propose your changes to the project:

1. Create a pull Request by clicking the button pull requests

   You will see that your new branch is listed at the top with a handy "Compare
   & pull request" button. Then click on this button.

   Next, make sure you provide a good short title for your pull request and
   explain why you created it, Add mention any issues numbers if you have any.

2. Submit the Pull request.

---

## Coding standars and quality process

### Coding standars

`Make sure your code follow the Coing Standards`

- [ Codeing standars ]
  (https://symfony.com/doc/current/contributing/code/standards.html)
- [ PHP Standars Recommendations PSRs ] (https://www.php-fig.org/psr/)

### Quality process

`For this project we using`

- [Codacy](https://app.codacy.com/gh/rachel-duret/ToDoList/dashboard)to
  following our code quality.

#### Test

`For this project we using`

- [PHPUnit](https://phpunit.de/documentation.html) for the unit tests and web
  tests

      > Examples: [Symfony Testing](https://symfony.com/doc/current/testing.html)

#### Performance:

`For this project we using`

- [Profiler](https://symfony.com/doc/current/profiler.html) to check the impact
  on the performance

##### Thank you for your contribuer.

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
