# ToDoList

Base du projet #8 : Améliorez un projet existant

https://openclassrooms.com/projects/ameliorer-un-projet-existant-1 Package

## 3 to 4:

```
    Remove doctrine/doctrine-cache-bundle. It's already  abandoned
    Remove Package doctrine/reflection It's already  abandoned,  Use roave/better-reflection instead.
    Remove swiftmailer/swiftmailer It's already  abandoned,  Use symfony/mailer instead.
    Remove Package symfony/swiftmailer-bundle It's already  abandoned, Use symfony/mailer instead.
```

### Composer require symfony/flex

    ```
    Follow the symfony/skeleton to confige composer jsopn-> https://github.com/symfony/skeleton/blob/4.0/composer.json
    copy to composer require
     "symfony/console": "*",
        "symfony/dotenv": "*",
        "symfony/framework-bundle": "*",
        "symfony/yaml": "*"
    copy to composer to replace "extra": and "symfony"
     "scripts": {
        "auto-scripts": [
        ],
        "post-install-cmd": [
            "@auto-scripts"
        ],
        "post-update-cmd": [
            "@auto-scripts"
        ]
    },
    "conflict": {
        "symfony/symfony": "*"
    },
    "extra": {
        "symfony": {
            "allow-contrib": false,
            "require": "4.0.*"
        }
    }
    after install symfony/flex this are new folders in the app,
