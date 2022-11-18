# Open Classrooms project 8 ToDo&Co, Created by Chun Cheung Duret at 17/11/2022

## How to contribute :

Enhance an existing Symfony application from ToDo&Co. This is an application to
manage daily tasks. Following the steps below to contribute the project:

### Step 1: Setup technical Requirements

Before contributer this project you must:

- Install PHP 8.1 or higher PHP extensions

- Install Composer, which is used to install PHP packages.

### Step 2: Get the github repository

- Go to ToDoList github repository <https://github.com/rachel-duret/ToDoList> on
  the top right of the page by clicking the button **Fork** to create a new
  fork.

- Clone the project following the command

```git clone https://github.com/rachel-duret/ToDoList.git
    or simplement downloas ZIP file

    To run the project by following README.md file
```

- Add the original ToDoList repository as a "git remote" called upstream.

The remote repository on your GitHub and called "origin".

At this point, if you want to keep your fork in sync with the toDoList forked
repository, you need to configure "git remote" that points to the original
project so that you can retrieve the changes and import them into your local
copy.

First click on the link to the original repository – it's labeled "Forked from"
at the top of the GitHub page. This takes you back to the GitHub page of the
main project, so you can find the "SSH cloning URL" and use it to create the new
"git remote", which we'll call "upstream".

Run the command

```
        git remote add upstream https://github.com/rachel-duret/ToDoList.git
```

Check the new upstream repository specified for you fork:

**git remote -v**

**origin** <https://github.com/Your-USERNAME/ToDoList.git> for fetch

**origin** <https://github.com/Your-USERNAME/ToDoList.git> for push

**upstream** <https://github.com/rachel-duret/ToDoList.git> for fetch

**upstream** <https://github.com/rachel-duret/ToDoList.git> for fetch

now you have two **remote** for this project:

```
    1. Origin, which points to your github repository of the project . You have teh right to write .
    2. Upstream, which points to the github repository of the current project. You do not have the right to write.
```

Retrieve all commits from the upstream branches by running the command:

```
    git fetch upstream
```

The purpose of this step is to allow you to work simultaneously on the official
ToDoList repository and on your own fork.

### Step 3: Work on the project:

1. Run the project by following the README.md file.
2. Navigate to you project directory.
3. Create a new branch. Using a short, remenberable name for this branch
4. Push your new branch to you repository

### Step 4: Propose your changes to the project:

1. Create a pull Request by clicking the button pull requests

```
    You will see that your new branch is listed at the top with a handy "Compare & pull request" button. Then click on this button.

On this page, make sure that the base fork points to the right repository and branch. In this example, the base fork should be rachel-duret/ToDoList , compare should be which is on the branch on which you selected to base your changes.

The primary head fork should be GITHUB-USERNAME/ToDoList (your fork copy of ToDoList) and the comparison branch should be "my-new-feature", which is the name of the branch you created and where you made your changes.

Next, make sure you provide a good short title for your pull request and explain why you created it in the description box. Add any issues  numbers if you have any.
```

2. Submit the Pull request

## Coding standars and quality process

### Coding standars

Make sure your code follow the Coing Standards

1. [ Codeing standars ]
   <https://symfony.com/doc/current/contributing/code/standards.html>
2. [PHP Standars Recommendations PSRs]<https://www.php-fig.org/psr/>

### Quality process

For this project we using
[Codacy]<https://app.codacy.com/gh/rachel-duret/ToDoList/dashboard> to following
our code quality.

#### Test

For this project we using [PHPUnit]<https://phpunit.de/documentation.html> for
the unit tests and web tests Example for [Symfony Testing]
<https://symfony.com/doc/current/testing.html>

#### Performance:

For this project we using [Blackfire]<https://www.blackfire.io/> to check the
impact on the performance

##### Thank you for your contribuer.
