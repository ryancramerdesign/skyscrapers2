## Skyscraper template files

In this Skyscrapers profile, please note the following locations:

### `_init.php`  

This file is automatically included before all other template files.
We use it to define our output regions, while the individual
template files populate those regions.

### `_main.php`  

This file is automatically included after all other template files.
We use it as our main markup file to output everything. It outputs
the regions defined in the `_init.php` file into the appropriate
locations.

### `_func.php`  

This file contains shared functions for finding skyscrapers and
rendering lists of skyscrapers, maps, and more.

### `includes/`  

We have placed our common markup rendering/views in this directory.
These files are rendered from the template files as needed.

## Requirements

These template files require ProcessWire 3.0.39 or newer.

These template files also require the following settings 
in your /site/config.php file: 

- `$config->useFunctionsAPI = true;`
- `$config->prependTemplateFile = '_init.php';`
- `$config->appendTemplateFile = '_main.php';`
