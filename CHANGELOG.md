## 2.0.0
 New major release
 WARNING: this major release is not backward compatible. If you upgrade from 1.x you will need to update your code and settings.
 - Category layout mechanism has changed: instead of using separators we use now open and close tags. This change will break your category structure. You may need to reset it and adjust your CSS as well.
 - Change category map Javascript namespace to catMap: this will break your category if you have additional code that interacts with the map.
 - Serialized field values are processed into arrays before converting them to JSON: this will break your site if you have Javascript that reads JSON output, and you have fields that include serialized data

## 1.23.0
 Add
 - Custom Google Map marker icons

## 1.22.0
 Add
 - New redirect template allows to set a redirect URL for categories and items, allowing the creation of URLs but preventing visitors from reaching those pages

## 1.21.4
 Fix
 - Correct syntax errors

## 1.21.3
 Fix
 - Append category alias to Javascript variable to avoid multiple subcategories overriding each other

## 1.21.2
 Change
 - Code cleanup

## 1.21.1
 Change
- Process attributes into a string before returning them

## 1.21.0
 Add
 - New function to add custom HTML attributes to categories and items

## 1.20.1
 Change
 - Make JSON functions return values instead of echoing them

## 1.20.0
 Change
 - Moved JSON template functionality from the json folder to functions.php to allow for easy copying of the json template
 - Refactored the whole logic that generates JSON output

## 1.19.1
 Remove
 - Update script was removed because it can accidentally update templates

## 1.19.0
 Add
 - New parameter to set teaser text and image for subcategories

## 1.18.1
 Fix
 - Correct default parameter value for JSON functionality

## 1.18.0
 Add
 - New parameter to set custom CSS classes for category and item page wrappers
 - New function to programmatically set custom CSS classes for category and item page wrappers

## 1.17.1
 Change
 - Include option for control whether field values and/or display should be included in JSON output

## 1.17.0
 Add
 - New options to generate JSON output in category and items view, in addition or instead of HTML

## 1.16.0
 Add
 - New functionality to control ordering of intro/featured/leading items in categories

## 1.15.2
 Remove
 - Unnecessary counter code

## 1.15.1
 Add
 - CHANGELOG file

## 1.15.0
 Add
 - CSS section parameters to allow custom CSS classes to be added to item sections
 
## 1.14.2
 Fix
 - Revert data-item-id to data-itemid

## 1.14.1
 Fix
 - Fix group names in item view
 
## 1.14.0
 Add
 - Include/exclude items by content type in category view
 
## 1.13.1
 Change
 - Minor edits to functions.php
 
## 1.13.0
 Add
 - Sub-category sections selection and ordering functionality (title, image, description, items)
 
## 1.12.0
 Add
 - New option for ordering item field groups and inserting separators
 
## 1.1## 1.0
 Add
 - Automatic resize and centering of map on screen size change event
 
## 1.10.0
 Fix
 - Fix parameter name for sub-category items linked items (wrapping A tag)
 
 Change
 - Change the linked items settings to be disabled by default
 
## 1.9.0
 Add
 - Option to add CSS classes on field wrappers
  
## 1.8.1
 Change
 - Simplify code for generating field value when field is core
  
## 1.8.0
 Change
 - Updates to JSON template
 
 Add
 - Parameters to control what core fields are included in output
 - Fields include label, value and display properties
  
## 1.7.2
 Change
 - Update xml files to use Bootstrap styles
  
## 1.7.1
 Fix
 - Fix for title rendering
  
## 1.7.0
 Add
 - Add itemid attribute to items and save map markers with itemid for access and manipulation with javascript

## 1.6.5
 Add
 - Add params for CSS classes for category sections
 
 Fix
 - Fix param name of CSS class for leading items section
 
## 1.6.4
 Change
 - Simplify code used for address field name
 
 Fix
 - Fix format of group class names
 - Fix field custom rendering function name

## 1.6.3
 Fix
 - Restore param for controlling if sub-category items are displayed under each subcategory
 - Fix bug in handling of category section layout ordering
  
## 1.6.2
 Fix
 - Fix class names for field groups in item view
 - Fix issue with an incorrect variable name of category layout ordering

## 1.6.1
 Add
 - New distribution files category-custom.dist.php and item-custom.dist.php
 
 Change
 - Updates to category layout sections ordering

## 1.6.0
 Add
 - New param for adding AddThis to item view
 - New param to control position of AddThis
 - New param to control embed code of AddThis (set services and custom styling)
 - New param for adding Disqus comments to item view
 - Item field group css class
 
 Fix
 - Filters link URL
 
## 1.5.0
 Add
 - Params for css classes for item lists (leading, intro, featured)
 - Params for css classes for alphaindex, filters, subcategories, map, pagination
 - Params for selecting engine for alphaindex and filters (FLEXIcontent or Lyquix)
 - Param for label for items section
 - Params for enabling AddThis, Discqus, control position, customize embed code 

## 1.4.1
 Add
 - Params for CSS classes for category sections

## 1.4.0
 Add
 - Linked item elem: adds a wrapping A tag for the whole item elem

## 1.3.0
 Add
 - "View all" link for sub-categories, linking to sub-category
 - Add fc-category and fc-item classes to wrapping DIV

## 1.2.1
 Fix
 - Fix bug that broke the template when there was no custom class/function

## 1.2.0
 Add
 - Functionality to display subcategory items using the same method as category items

## 1.1.2
 Add
 - Updated gitignore to include customization php files
 - Updated readme

## 1.1.1
 Fix
 - Update and copy functions of update.php
 
## 1.1.0
 Add
 - Update.php script for automatic update of all custom-* templates with latest version from Github
 - Label options for map and subcategories
 - CSS class for items lists and items
 
 Change
 - Cleanup category.xml
 
## 1.0.0
 Add
 - Updates to readme
 - Decoupled addthis, disqus and read more link from the description field, added param for select after what field should they be rendered
 - Add params for pre-text, post-text, open-tag and close-tags for items lists and items
 - New param to override/include a Written by label before author field
 
Fix
- Remove URL generation from AddThis code in item view
