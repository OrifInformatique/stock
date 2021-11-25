# Stock

Web application to manage items inventory, loans and more.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

This project is developed on a LAMP server with PHP 7.4 and MariaDB 10.4.
It is based on the CodeIgniter 4.x framework.

### Installing

1. Download [our latest release](https://github.com/OrifInformatique/stock/releases)
2. Unzip your download in your project's directory (in your local PHP server)
3. Rename .env_dist file to .env and adapt it for your server's parameters
4. Generate a local database running CodeIgniter's spark migrate command

```bash
php spark migrate -all
```

## Built With

* [CodeIgniter 4.x](https://www.codeigniter.com/) - PHP framework
* [Bootstrap](https://getbootstrap.com/) - Design library with personalized css

## Authors

* **Orif, domaine informatique** - *Initiating and following the project* - [GitHub account](https://github.com/OrifInformatique)

See also the list of [contributors](https://github.com/OrifInformatique/stock/contributors) who participated in this project.
