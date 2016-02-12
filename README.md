# flexicontent_templates

##What is this?##

Lyquix has been using FLEXIcontent since 2010 and we have developed countless custom templates for FLEXIcontent. In our experience the template structure provides great flexibility to generate categories and items exactly how we need them. However, it also requires a lot of code writing.

The purpose of the Lyquix FLEXIcontent template is to allow us to deploy highly-customized templated, without having to rewrite a lot of PHP code. The json template can be used to provide a simple API for external systems to read content published using FLEXIcontent.

##Who is this for?##

These templates are for advanced developers only. Don't expect to install it and see something pretty right away. They require a lot of configuration but provide you a high level of customization.

##Features##

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
  * Item lists
    * Ability to separate featured items in its own list (UL)
    * Control whether the "No Items Found" label should be displayed, and what text to use
    * Select the tag for items title *
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
    * Use PHP to generate custom CSS classes for subcategories and items 
    * JSON template can be used as a simple API to feed external systems, javascript code, or mobile apps

(*) While many of these customizations are available directly on the fields settings, having them on the template allow to set them on a category- and type-level.

##Positions##

One of the most practical features of the FLEXIcontent templating system is the ability to drag-and-drop fields into pre-defined positions. The Lyquix template provides 7 positions plus render-only both in the category and item templates. In our experience, 7 positions provide enough room for the most complex layouts and designs.

It is possible to add CSS classes to each position for styling purposes.

In the future we want to add the option to group some of the position DIVs in order to allow for even more complex layouts.

##File Structure and Mechanics of the Template##

The template is structured in two directories: `lyquix` and `custom`.

The **`lyquix`** directory contains the common code. You should not use this template with categories or content types.

The **`custom`** directory contains the base files for your custom templates. You can assign this template directly to categories and types, but it is not recommended. Instead make copies of this template for your project. For example: custom-services, custom-people, etc.

In your custom directories you will find the typical files:

```
category.php
category.xml
item.php
item.xml
```

Do not modify these files! They are overwritten when the template is updated. If you open the XML files you can find all the fields that we have created to make it easy to configure the template. The PHP files are very simple and they only perform the following functions:

1. Load `category-custom.php` and `item-custom.php` if they exist - these files contain customizations for field display and CSS classes (described later)
2. Load the main `category.php` and `item.php` files found in the `lyquix` folder

###Category View###

The file `category.php` in the `lyquix` folder is quite simple too. It loads the file `functions.php` that defines a private class with several functions. 

In the case of the category view the layout can be fully customized to a specific order. The various sections: title, buttons, filters, alpha-index, image, description, map, sub categories, items and pagination can be enabled, disabled and sorted via the Joomla backend. Additionally, these sections can be wrapped by additional DIVs to provide the necessary structure for your design. 

Each section of the category has a corresponding function in `functions.php` that takes care of rendering it. If you inspect the file you will see that have take care of making our naming convention consistent so that we can reuse code as much as possible.

###Item View###

There aren't as many features for the item view as for the category view.

The file `item.php` is similar to the category counterpart. It loads the file `functions.php` that provide the function for rendering fields. It is possible to define where to load the sharing buttons, and specify custom CSS classes for the field positions.

##Advanced Customization##

The template allows for advanced customization. You can add custom CSS classes to subcategories and items using PHP, customize the rendering of fields, and the rendering of category sections (title, image, description, alphaindex, filters, sub-categories, items and pagination) to fit your needs. This feature is available for category and item views. 

This is implemented by adding files `category-custom.php` and `item-custom.php` in your template folder that are loaded only if they exist. Refer to the files `category-custom.dist.php` and `item-custom.dist.php` as samples of the basic structures that these customizations must have. They load a PHP class with specific functions that are executed by the template. Remember that you can use `$this` to access all the information of the category, subcategories and items.

**`customSubcatClass`**

Inputs: 
  * `$subcat` an object representing the current sub category being rendered

Output: 
  * Array containing the CSS classes to be applied to the sub-category element.

**`customItemClass`**

Inputs: 
  * `$item` an object representing the current item being rendered
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output: 
  * Array containing the CSS classes to be applied to the item element.

**`customFieldRendering`**

Inputs: 
  * `$item` an object representing the current item being rendered
  * `$field` an object representing the current field object
  * `$group` a string that indicates the item group: subcategory, map, leading, intro, featured

Output: 
  * String containing the rendered HTML

**`customSectionRendering`**

Inputs: 
  * `$section` a string that indicates what section is currently being rendered

Output:
  * String containing the rendered HTML

