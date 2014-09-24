# LCBO Product Story
This PHP/jQuery plugin searches through the unofficial LCBO API and returns a store map of the locations.

## Setup
Change in <code>sage_lcbo.js</code> the products you wish to search for in a csv.
    createLocator("getlcbo.php?products=372078,372060");
Change in <code>infowindow-description.html</code> the output you wish for. Typically this will be for the products names.

## Limitations
Currently does not support products with >100 stores

## Built Ontop of
LCBO API
[lcboapi.com](http://lcboapi.com/docs/stores-with-product)

STORE LOCATOR PLUGIN
[jQuery Store Locator](http://www.bjornblog.com/web/jquery-store-locator-plugin)
