# Socle Symfony 5.2
## Socle technique pour les projets Symfony avec une architecture modulaire

Plateforme développée par Thomas JARDOU.

### Configuration serveur
- Nginx / Apachevqui pointe vers le dossier /public

### Stack de développement
- BackEnd : PHP 8.0.0, MySQL 5.7, Symfony 5.2
- FrontEnd : TailwindCSS, Yarn (NodeJS), AlpineJS, jQuery

### Fonctionnalités
- Sécurité

## Installation

Changer les informations dans le .env (base de données et mailer)
```sh
nano .env

###> doctrine/doctrine-bundle ###
DATABASE_URL="mysql://username:password@host:port/dbname?serverVersion=5.7"

###< doctrine/doctrine-bundle ###
MAILER_DSN=smtp://username:password@host:port/?encryption=ssl&auth_mode=login
```

Après avoir configurer le .env
```sh
cd socle-symfony
composer install
yarn install
yarn encore dev
```

Pour installer la base de données (au premier démarrage) :
```sh
cd socle-symfony
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```


```.env
APP_ENV=prod
```
puis
```sh
cd socle-symfony
composer install
yarn install
yarn encore production
```

Pour installer les fixtures (rôle administrateur) :
```sh
php bin/console doctrine:fixtures:load
```