# Conventions in this project #

In addition to [CodeIgniter's conventions](https://codeigniter.com/user_guide/general/styleguide.html), we use our own additional conventions.  
Functions and classes should be documented with DocBlock.  

## Ignored CodeIgniter conventions ##

There is no need to use `OR` instead of `||`.  
Usage of `<?=$var;?>` is recommended, as CodeIgniter recommends at least 5.6, meaning it should work anyway.  
The use of spaces instead of tabs for indentation is encouraged. You might see them mixed in some files.  
There is no convention for end of lines.

## HTML/PHP and CSS ##

Element ids and classes are in kebab-case, as Bootstrap classes.

## CSS ##

Files are stored in */public/css*.  
Filenames start with *MY_* and end with *.css*.

## Javascript ##

Variables and functions are named in camelCase.  
Variables should be declared using `let` or `const` instead of `var`.  
Classes are named in PascalCase.  
Files are stored in */public/js*.  
Filenames start with *MY_* and end with *.js*.  
If a function is used only in one view, it can be added at the end of that view.

## Images ##

Images used in the application's template are stored in */public/images*.  
If the application lets the user upload his own pictures, these will be stored in a separate folder (for example "uploads" folder).

## SQL and database ##

SQL scripts should allways be present in root/database folder for application specific tables and in application/module/{module name}/database folder for module tables.  
One script to generate a new empty database and upgrade scripts to update from a version to the next without affecting content datas.  
Tables and attributes must be all lowercase and snake_case.  
No prefix is used for tables names.  
fk_ prefix is used for foreign keys.  

## PHP (in general) ##

Variables are in camelCase.  
Functions are in snake_case.  
Classes are in Upper_snake_case.

## CodeIgniter ##

### Controllers ###

Must extend MY_Controller.  
Are stored in either */application/controllers* or */application/modules/{module name}/controllers*.  
Names are in Upper_snake_case, and should only be a single word.  
Read methods (e.g. a list) should start with `list_` for the list, or `detail_` for a specific item, both followed by the type in singular (e.g. `list_user`).  
Create and update methods should start with `save_` for displaying the form and validating the input, both followed by the type in singular.  
Delete methods should start with `delete_`, also followed by the type.  
If there is only one type, simply use `list`, `detail`, `save`, and `delete`.  
`index` should call the first list.  
CI callbacks for form_validation must start with `cb_`.

### Models ###

Must extend MY_Model.  
Names are in snake_case, and end with *_model*.  
Custom create methods should start with `insert_`, read methods with `get_`, update methods with `update_`, and delete methods with `delete_`.
Other methods should start with a verb.

### Views ###

Names are in snake_case, must have the name of the method calling them with *.php* at the end (e.g. *list_user.php*).  
Views should be placed in folders named after the calling controller.  
Subfolders are allowed for further differenciation.  
Whenever possible, use `<?=$var;?>` instead of `<?php echo $var; ?>`.

### Lang ###

Use prefixes and suffixes accordingly.  
If you need to use more than one, put the highest first.  
Feel free to expand this list.

#### Prefixes ####

| Represents    | Prefix    |
| ------------- | --------- |
| Page title    | title_    |
| Nav link      | nav_      |
| Field label   | field_    |
| Placeholder   | phd_      |
| Button        | btn_      |
| Message       | msg_      |
| Error         | err_      |

#### Suffixes ####

| Represents    | Suffix    |
| ------------- | --------- |
| Confirmation  | _confirm  |

## User Interface ##

All pages must be displayed alongside the views in the common module.  
The order is *header.php*, *login_bar.php*, the view(s), *footer.php*.  
It is done automatically by calling `MY_Controller::display_view`.

### Lists ###

Must be a table with the `table` class.  
The table headers are in a thead.  
The create button must be at the top left of the list.  
The link for modifying an entry should be on the most descriptive part of it (e.g.: username for an user).  
Deletes should be `a`s containing an x using the `close` class.

### Forms ###

Inputs use the `form-control` class.  
Inputs should be in `div`s using the `form-group col` classes.  
Additionally, the label must be right above the input.  
Each `div` must be in another `div` using the `row` class. It may contain more than one input.  
The cancel/save buttons should be at the bottom-right of the form.  
If the form is big enough, they should also be at the top-right.

### Buttons ###

Cancel buttons use the `btn-default` class, confirm/create buttons use the `btn-primary`.  
Hard delete buttons use the `btn-danger` class.  
All buttons use the `btn` class.  
Buttons do not use Bootstrap `col`s classes.  
Cancel buttons must be the leftmost buttons.
