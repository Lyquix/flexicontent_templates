# flexicontent_templates

##What is this?##

Lyquix has been using FLEXIcontent since 2010 and we have developed countless custom templates for FLEXIcontent. In our experience the template structure provides great flexibility to generate categories and items exactly how we need them. However, it also requires a lot of code writing.

The purpose of these templates is to allow us to deploy highly-customized templated, without having to rewrite a lot of PHP code.

##Features##

  * Provides a select2 sortable field for defining what parts of the category should be included and in what order (description, image, subcategories, buttons, filters, items, pagination...)
  * Allows to override the category title
  * Select alignment of category image
  * Override heading label for filters section
  * Override heading label for alpha-index section
  * Override heading label for sub-categories section
  * Add custom CSS class for sub-categories list and items (UL and LI tags)
  * Select tag for sub-category titles
  * Sub-category alignment
  * Option to show items under each sub-category (and exclude them from main items list) 
  * Display map of items
    * Control Google map dimensions and controls
    * Render pins on map using lat/lon coordinates from Address field
    * Include item information in map bubbles
  * Item lists
    * Ability to separate featured items in a separate list (UL)
    * Control whether the "No Items Found" label should be displayed, and what text to use
    * Select the tag for items title *
    * Select field to be used as title string
    * Select field to be used as description string
    * Select field for item image, and set custom image dimensions and alignment *
    * Custom date format *
    * Custom label for read more button
    * Custom "written by" label for author field *
    * Custom CSS class for item tag (LI)
    * Custom headings for featured items, leading items and intro items

(*) While many of these customizations are available directly on the fields settings, having them on the template allow to set them on a category- and type-level.

##Positions##

One of the most practical features of the FLEXIcontent templating system is the ability to drag-and-drop fields into pre-defined positions. The Lyquix template provides 7 positions plus render-only both in the category and item templates. In our experience, 7 positions provide enough room for the most complex layouts and designs.

It is possible to add CSS classes to each position for styling purposes.

In the future we want to add the option to group some of the position DIVs in order to allow for even more complex layouts.

To do:
Custom field display
CSS classes based on field values
File Structure

