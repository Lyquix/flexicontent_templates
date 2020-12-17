# flexicontent_templates

@version     2.3.0

## What is this?

Lyquix has been using FLEXIcontent since 2010 and we have developed countless custom templates for FLEXIcontent. In our experience the template structure provides great flexibility to generate categories and items exactly how we need them. However, it also requires a lot of code writing.

The purpose of the Lyquix FLEXIcontent templates is to allow us to deploy highly-customized templated, without having to rewrite a lot of PHP code. The JSON template can be used to provide a simple API for external systems to read content published using FLEXIcontent. The Redirect template can be used to redirect categories and items to another URL.

## Who is this for?

These templates are for advanced developers only. Don't expect to install it and see something pretty right away. They require a lot of configuration but provide you a high level of customization.

## Features

  * General layout
    * Provides a select2 sortable field for defining what parts of the category should be included and in what order (description, image, subcategories, buttons, filters, items, pagination...)
    * Create complex HTML layouts by addition of separators that create DIV wrappers around the various category sections, with the option for custom CSS classes
    * Allows to override the category title
    * Select alignment of category image
    * Override heading label for filters, alpha-index, subcategories and items sections
    * Add custom CSS classes for sub-categories and items lists (UL and LI tags), and for field positions
    * Add custom HTML at the beginning and end of each section, and at the beginning and end of each item
  * Sub-categories
    * Select tag for sub-category titles
    * Set sub-category image alignment
    * Custom ordering of sub-category elements (title, image, description and sub-category items)
    * Option to display sub-category items and to and choose whether to exclude them from main item lists
  * Map
    * Control Google map dimensions and controls
    * Render pins on map using lat/lon coordinates from AddressInt field
    * Include item information in map bubbles
    * Custom marker icons set for the whole map or on an item-by-item basis
  * Filters
    * Provides a JavaScript API that interacts with FLEXIcontent advanced filters
    * Allows to provide filtering functionality without reloading page
    * Provides a mechanism for creating aliases for specific filters
  * Item lists
    * Ability to separate featured items in its own list (UL)
    * Control the order in which leading, intro and featured items groups are displayed
    * Control whether the "No Items Found" label should be displayed, and what text to use
    * Select the HTML tag to use for items title *
    * Select field to be used as title string
    * Select field to be used as description string
    * Select field to be used for image, and set custom image dimensions and alignment *
    * Custom date format *
    * Custom label for read more button
    * Custom "written by" label for author field *
    * Option to insert AddThis bar in category and item views, and customize AddThis embed code
    * Option to insert Disqus comment count in category view
    * Custom CSS classes for each field position
    * Custom CSS classes for field wrappers
  * Advanced development
    * Customize rendering of any section of categories (title, description, image, alphaindex, filters, items, subcategories, pagination)
    * Customize rendering of fields
    * Use PHP to generate custom CSS classes and HTML attributes for subcategories and items
    * Generate JSON output in categories and items in addition or instead of HTML
    * JSON template can be used as a simple API to feed external systems, javascript code, or mobile apps

(*) While many of these customizations are available directly on the fields settings, having them on the template allow to set them on a category- and type-level.

## Positions

One of the most practical features of the FLEXIcontent templating system is the ability to drag-and-drop fields into pre-defined positions. The Lyquix template provides 7 positions plus render-only both in the category and item templates. In our experience, 7 positions provide enough room for the most complex layouts and designs.

It is possible to add CSS classes to each position for styling purposes.

In the future we want to add the option to group some of the position DIVs in order to allow for even more complex layouts.

## File Structure and Mechanics of the Template

The template is structured the directories: `lyquix`, `custom`, `json` and `redirect`.

The **`lyquix`** directory contains the common code. You should not assign this template to categories or content types, and there is no need to duplicate it.

The **`custom`** directory contains the base files for custom template. Do not assign this template directly to categories and types, instead make copies of this template for your project. For example: custom-services, custom-people, etc. You can then customize the settings and field-position assignments for each. You will gain several template options in your categories and items.

The **`json`** directory contains the base files for the JSON templates. Do not assign this template directly to categories and types, instead make copies of this template for your project. For example: json-services, json-people, etc. You may not want to assign these templates to categories and content types, instead call them by adding the `clayout` and `ilayout` parameters to categories and items to generate a JSON file. You can also include a `callback` parameter to generate a JSONP output.

Examples:
`http://domain/path/to/category/services?clayout=json-services`
`http://domain/path/to/category/people?clauout=json-people&callback=myFunc`
`http://domain/path/to/item/people?ilauout=json-people`

The **`redirect`** directory contains the base files for the Redirect template. You may assign this template directly to categories and content types, and items, and enter the redirect URL in the template parameters.

In the custom directories you will find the following typical files:

```
category.php
category.xml
item.php
item.xml
```

Do not modify these files! They are overwritten when the template is updated. If you open the XML files you can find all the fields that we have created to make it easy to configure the template.

You will also find the files

```
category-custom.dist.php
item-custom.dist.php
```

That are the sample files for custom logic for your categories and items. Copy them into `category-custom.php` and `item-custom.php`.

The files `category.php` and `item.php` are very simple and they only perform the following functions:

1. Load `category-custom.php` and `item-custom.php` if they exist - these files contain customizations for field display and CSS classes (described later)
2. Load the main `category.php` and `item.php` files found in the `lyquix` folder

### Category View

The file `category.php` in the `lyquix` folder is quite simple too. It loads the file `functions.php` that defines a private class with several functions.

In the case of the category view the layout can be fully customized to a specific order. The various sections: title, buttons, filters, alpha-index, image, description, map, sub categories, items and pagination can be enabled, disabled and sorted via the Joomla backend. Additionally, these sections can be wrapped by additional DIVs to provide the necessary structure for your design.

Each section of the category has a corresponding function in `functions.php` that takes care of rendering it. If you inspect the file you will see that have take care of making our naming convention consistent so that we can reuse code as much as possible.

### Item View

There aren't as many features for the item view as for the category view.

The file `item.php` is similar to the category counterpart. It loads the file `functions.php` that provide the function for rendering fields. It is possible to define where to load the sharing buttons, and specify custom CSS classes for the field positions.

## Advanced Customization

The template allows for advanced customization. You can add custom CSS classes to subcategories and items using PHP, customize the rendering of fields, and the rendering of category sections (title, image, description, alphaindex, filters, sub-categories, items and pagination) to fit your needs. This feature is available for category and item views.

This is implemented by adding files `category-custom.php` and `item-custom.php` in your template folder that are loaded only if they exist. Refer to the files `category-custom.dist.php` and `item-custom.dist.php` as samples of the basic structures that these customizations must have. They load a PHP class with specific functions that are executed by the template. Remember that you can use `$this` to access all the information of the category, subcategories and items.

**`customCatClass`**
Custom CSS classes for the category wrapper element

Inputs:
  * `$category` an object representing the current category being rendered

Output:
  * String containing the CSS classes to be applied to the category wrapper element.

**`customCatAttrs`**
Custom HTML attributes for the category wrapper element

Inputs:
  * `$category` an object representing the current category being rendered

Output:
  * String containing the HTML attributes to be applied to the category wrapper element.

**`customMapMarker`**
Custom marker icon for individual items

Inputs:
  * `$item` an object representing the current item being rendered

Output:
  * String containing the URL of custom marker icon to use.

**`customSubcatClass`**
Custom CSS classes for sub categories

Inputs:
  * `$subcat` an object representing the current sub category being rendered

Output:
  * String containing the CSS classes to be applied to the sub-category element.

**`customSubcatAttrs`**
Custom HTML attributes for sub categories

Inputs:
  * `$subcat` an object representing the current sub category being rendered

Output:
  * String containing the HTML attributes to be applied to the sub-category element.

**`customItemClass`**
Custom CSS class for items

Inputs:
  * `$item` an object representing the current item being rendered
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output:
  * String containing the CSS classes to be applied to the item element.

**`customItemAttrs`**
Custom HTML attributes for items

Inputs:
  * `$item` an object representing the current item being rendered
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output:
  * String containing the HTML attributes to be applied to the item element.

**`customFieldRenderingPretext`**
Text to be added before rendering a field

Inputs:
  * `$item` an object representing the current item being rendered
  * `$field` an object representing the current field object
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output:
  * String

**`customFieldRendering`**
Custom rendering of specific fields

Inputs:
  * `$item` an object representing the current item being rendered
  * `$field` an object representing the current field object
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output:
  * String containing the rendered HTML

**`customFieldRenderingPosttext`**
Text to be added after rendering a field

Inputs:
  * `$item` an object representing the current item being rendered
  * `$field` an object representing the current field object
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output:
  * String

**`customSectionRenderingPretext`**
Custom text to be added before rendering of a category section

Inputs:
  * `$section` a string that indicates what section is currently being rendered

Output:
  * String

**`customSectionRendering`**
Custom rendering of a category section

Inputs:
  * `$section` a string that indicates what section is currently being rendered

Output:
  * String containing the rendered HTML

**`customSectionRenderingPosttext`**
Custom text to be added after rendering of a category section

Inputs:
  * `$section` a string that indicates what section is currently being rendered

Output:
  * String

Functions for items follow the same naming convention
