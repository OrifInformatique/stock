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
3. Copy .env_dist file and rename to .env, then adapt it for your server's parameters
```
FOR EXAMPLE

[...]

CI_ENVIRONMENT = development

[...]

app.baseURL = 'http://localhost/stock/public/'

[...]

database.default.hostname = localhost
database.default.database = stock
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi

[...]

```
4. Generate a local database running CodeIgniter's spark migrate commands

```bash
php spark migrate -n Stock
php spark migrate -n User
```

## Upgrade Version 1.6 to Version 4.0

This upgrade makes lot of changes as the application is adapted to new CodeIgniter 4.x. Please follow carefully these steps and try it in a test environment before.

1. BE SURE TO HAVE A COMPLETE BACKUP OF YOUR APPLICATION (DATABASE AND FILES)
2. With FTP connexion, remove all files and folder from the hosting server, except for the "uploads" folder
3. With FTP connexion, upload all the content of Version 4.0 release to the hosting server
4. Move the "uploads" folder from root to "public" folder
5. Rename the .env_dist file to .env and adapt its content to your hosting environment
6. Delete the orif/stock/Database/Migrations/restore_CI3_version folder
7. Browse to APPLICATION_URL/stock/migrate/toCI4
8. Enter the password that you can find in orif/stock/Controllers/Migrate.php (line 49) and validate
9. Delete the file orif/stock/Controllers/Migrate.php
10. Delete the folder orif/stock/Views/migration
11. Browse to the application and connect with an administrator account
12. Browse to APPLICATION_URL/clean_images/index
13. Click on "Yes" to execute the script which will clean up the items images
14. Delete the file orif/stock/Controllers/Clean_images.php
15. Delete the folder orif/stock/Views/admin/clean_images
16. Delete the folder orif/stock/Commands
17. VERIFY THAT ALL THE APPLICATION WORKS WELL

## Built With

* [CodeIgniter 4.x](https://www.codeigniter.com/) - PHP framework
* [Bootstrap](https://getbootstrap.com/) - Design library with personalized css

## Authors

* **Orif, domaine informatique** - *Initiating and following the project* - [GitHub account](https://github.com/OrifInformatique)

See also the list of [contributors](https://github.com/OrifInformatique/stock/contributors) who participated in this project.
