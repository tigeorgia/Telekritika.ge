hypeFramework is part of the hypeJunction plugin bundle

============
www.hypeJunction.com
hypeJunction is here for you to connect, innovate, integrate, collaborate and indulge.
hypeJunction is a bundle of plugins that will help you kick start your Elgg-based social network and spice it up with cool features and functionalities.
============

DEMO
----
http://www.hypeJunction.com/demo18

PLUGIN DESCRIPTION
------------------
hypeFramework is a collection of 
    1) PHP classes
    2) Generic and re-usable JS, PHP scripts and libraries
    3) Visual elements, wrappers and views
    4) Cascade Style Sheets (grids)
    
Noteworthy characteristics:
- hypeFramework is a wrapper plugin for a specific data logic. This model represent an hierarchy of encapsulated objects, which allows for modular representation of information.
Namely:
- Plugin Level Objects (plugins specific objects, e.g. portfolio)
   |
   --> Segmentation (sub-pages, tabs)
        |
        --> Sections (form-driven content patterns)
            |
            --> Section containers (widgets, data blocks)
                |
                --> Content Items 

- hypeFramework introduces new ElggObjects - forms and fields - which help to streamline data collection and form management
- hypeFramework streamlines representation of content items (similar menu structure, fancybox popups, scrollers etc)


REQUIREMENTS
------------
1) Elgg 1.8+

INSTALLATION
------------
1) Unzip hypeFramework into your mod/ folder
2) Enable hypeFormBuilder in your administrator control panel

USER GUIDE
----------
- As a standalone plugin, hypeFramework does not add any functionality. It must be used in conjunction with other hypeJunction plugins

BUG REPORTS
-----------
Bugs and feature requests can be submitted at:
http://hypeJunction.com/trac

MIGRATION NOTES
---------------
Please note that hypeFramework 1.8 is not based on hypeFramework 1.7, and therefore hypeJunction plugins of newer version may not always be compatible with their predecessors. Special migration scripts may be required.

TODO
----
- Complete phpDoc documentation of functions
- Refactor some of the functions as to avoid duplication
- Add email support
- Compress urls or find an alternative for passing arrays of variables