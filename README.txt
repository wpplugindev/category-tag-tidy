=== Category Tag Tidy ===
Contributors: wpplugins-tech
Tags: Category, Tag, Multisite, clean, tidy, unused tags, unused categories, delete
Requires at least: 4.0
Tested up to: 5.3.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Allows easy deletion of unused categories and tags - maintains existing category structure. 

== Description ==

Allows quick and simple deletion of all unused categories and tags.
In order to maintain your categories structure - unused parent categories will not be deleted if they have a child category still in use.
For multisite installations unused tags and categories on all sites can be quickly processed at the same time.

== Features ==

* Easily tidy up tags and categories on your site
* Maintains your existing category structure
* Easy for network admins to manage tags and categories across a wordpress multisite installation. 
* Translation Ready

== Documentation ==

* Select taxonomies to tidy - categories, tags or both

* Confirm on next screen

* For Multisite manage sites individually from each site's admin or manage all sites together when in NetworkAdmin

* Users who have permission to 'manage_categories' can access this tool ie: Editors and higher

* Note -  Unused Parent Categories will not be deleted if they have a child category still in use.
       -  Categories or Tags still linked with content in the trash will not be deleted.


### Links

- [GitHub Repository](https://github.com/wpplugins-tech/category-tag-tidy)

== Installation ==

1. Unzip the downloaded package
2. Upload `category-tag-tidy` to the `/wp-content/plugins/` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Access Category Tag Tidy under the Tools menu (or main menu if multisite)

== Screenshots ==
1. Main Form
2. Confirmation Page
3. Results Page
4. Network Admin Screen (multisite only)

== Changelog ==

= 1.0.0 =
* Initial Release