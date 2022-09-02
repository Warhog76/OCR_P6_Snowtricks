[![Codacy Badge](https://app.codacy.com/project/badge/Grade/b25447efb709441aa882e502659cc084)](https://www.codacy.com/gh/Warhog76/OCR_P6_Snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Warhog76/OCR_P6_Snowtricks&amp;utm_campaign=Badge_Grade)

# OCR_P6_Snowtricks

## Background
Jimmy Sweat is an ambitious entrepreneur with a passion for snowboarding. His goal is to create a collaborative website to make this sport known to the general public and to help people learn tricks.

He wishes to capitalize on content provided by Internet users in order to develop a rich content that will arouse the interest of the site's users. Then, Jimmy wishes to develop a business of connection with snowboard brands thanks to the traffic that the content will have generated.

For this project, we will focus on the technical creation of the site for Jimmy.

## Description of the need
You are in charge of developing the site to meet Jimmy's needs. You have to implement the following features :

a directory of snowboard tricks. You can be inspired by the list of tricks on Wikipedia. Just add 10 tricks, the rest will be entered by the users;
figure management (creation, modification, consultation);
a common discussion space for all figures.
To implement these features, you must create the following pages:

the home page where the list of figures will appear;
the page for creating a new figure;
the page for modifying a figure;
the presentation page of a figure (containing the common discussion space around a figure).

### Requested
For this project, you need :

- PHP 8.1
- Symfony 6

### Installation
Manually download the content of the Github repository to a location on your file system.\
You can also use git.\
In Git, go to the chosen location and execute the following command:
```
git clone https://github.com/Warhog76/OCR_P6_Snowtricks.git .
```

Open a command console and join the application root directory.\
Install dependencies by running the following command:
```
composer install
```

### Database generation

Change the database connection values for correct ones in the .env file.\
Like the following example with a snowtricks named database to create:
```
DATABASE_URL="mysql://root:@127.0.0.1:3306/snowtricks?serverVersion=5.7&charset=utf8mb4"
```

In a new console placed in the root directory of the application;\
Launch the creation of the database:
```
php bin/console doctrine:database:create
```

Then, build the database structure using the following command:
```
php bin/console doctrine:migrations:migrate
```

Finally, load the initial dataset into the database with example users.\
if you want to load the initial dataset and generic users, use this command:
```
php bin/console doctrine:fixtures:load
```

## Start project

Launch the Apache/Php runtime environment by using Symfony via the following command:
```
php bin/console server:run
```
Leave this console open.\
Then consult the URL <http://127.0.0.1:8000> from your browser.

## Made with
* [Bootstrap](http://materializecss.com) - Framework CSS (front-end)
* [Symfony](https://symfony.com/) - Framework PHP
* [Twig](https://twig.symfony.com/) - Template engine for PHP
* [PhpStorm](https://www.jetbrains.com/fr-fr/phpstorm/) - IDE

## Writers
* **Nicolas** _alias_ [Warhog76](https://github.com/warhog76)
