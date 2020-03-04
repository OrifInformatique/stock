# user module #

This module contains all elements needed for user administration and authentication.

## Configuration ##

This section describes the module's configurations available in the config directory.

### Access levels ###

Defines the access levels in powers of 2.  
By default, guest, registered, and admin access levels are defined.

### Validation rules ###

Defines the min/max length of usernames and passwords.

### password_hash_algorithm ###

Defines the algorithm to use for password hashing. Does not automatically update the database.

## Database and models ##

An SQL script defines the tables needed for this module. This script can be found in the module's "database" subfolder and can be executed in your database to generate the tables.

### user ###

Contains the user's basic informations such as id, user_type, username, password (hashed), archive status and creation date.
The archive status (boolean) is used as a soft delete key. An archived user cannot login anymore but his informations are kept in the database. The admin interface authorises soft or hard deletions.

### user_type ###

Defines a users access level, based on users types (roles).

## Dependencies ##

This module needs the CodeIgniter sessions system properly configured and working.
It assumes that HMVC, base model, base controller and bootstrap libraries are included in the CodeIgniter project.

## Authors ##

- **Orif, domaine informatique** - *Creating and following this module* - [GitHub account](https://github.com/OrifInformatique)
