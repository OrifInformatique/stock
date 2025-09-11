# Stock

Web application to manage items inventory, loans and more.

## Getting Started

These instructions will get you a docker environment up and running on your local machine for development and testing purposes.

### Prerequisites

This project is developed on a Docker environment with PHP 8.1 and MariaDB 10.11.
It is based on the CodeIgniter 4.x framework.
To run it with Docker you need to install [Docker Desktop](https://www.docker.com/products/docker-desktop/) at first.

### Installing

1. [Clone the project](https://github.com/OrifInformatique/stock)
2. Create a copy of the project root's "env_dist" file and rename it to .env, uncomment informations and adapt them if needed
3. From a terminal, go into the "ci-application" directory and run `composer install` to download required php packages (you have to install composer at first, you can [get it here](https://getcomposer.org/download/))
4. In the "ci-application" directory, create a copy of the "env_dist" file and rename it to .env, then adapt it to your Docker's parameters
```
FOR EXAMPLE

[...]

CI_ENVIRONMENT = development

[...]

app.baseURL = 'http://localhost/public/'

[...]

database.default.hostname = mariadb
database.default.database = stock_db
database.default.username = stock_user
database.default.password = stock_password
database.default.DBDriver = MySQLi

[...]

```
5. From a terminal, go into the root directory and run `docker-compose up --build`
6. Access a terminal in the Docker apache container with `docker-compose exec apache bash`
7. From this terminal, generate the database in mariadb Docker's container running CodeIgniter's spark migrate commands
```bash
php spark migrate -n Stock
php spark migrate -n User
```
8. Access your application (http://localhost/public)
9. Access phpMyAdmin (http://localhost:8080/)

## Run tests
1. Access a terminal in the Docker apache container with `docker-compose exec apache bash`
2. Run `vendor/bin/phpunit`

## Built With

* [CodeIgniter 4.x](https://www.codeigniter.com/) - PHP framework
* [Bootstrap](https://getbootstrap.com/) - Design library with personalized css

## Authors

* **Orif, domaine informatique** - *Initiating and following the project* - [GitHub account](https://github.com/OrifInformatique)

See also the list of [contributors](https://github.com/OrifInformatique/stock/contributors) who participated in this project.
