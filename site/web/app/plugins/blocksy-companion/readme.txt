=== Blocksy Companion ===
Tags: widget, widgets
Requires at least: 5.2
Requires PHP: 7.0
Tested up to: 5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

Blocksy Companion adds the extensions system to the Blocksy dashboard and introduces the Instagram extension.

This plugin runs and adds its enhacements only if the Blocksy theme is installed and active.

= Minimum Requirements =

* WordPress 5.0 or greater
* PHP version 7.0 or greater

== Installation ==

1. Upload `Blocksy-Companion-version_number.zip` to the `/wp-content/plugins/` directory and extract.
2. Activate the plugin by going to **Plugins** page in WordPress admin and clicking on **Activate** link.

== Changelog ==
1.7.2: 2020-04-03
- Improvement: Posts widget with post type, excerpt, custom query
- Improvement: About Me widget image size option
- Fix: Mailchimp widget submit without js
- Fix: WooCommerce ratio option on import

1.7.1: 2020-03-26
- New: Add Opengraph meta data option
- New: Add alignment & image size option for About Me widget
- Improvement: Refactor Mailchimp extension to better support RTL
- Fix: Themes Live Preview with Blocksy active

1.7.0: 2020-03-09
- Fix: Calendar widget issue
- Fix: Don't include sticky posts in Posts widget with custom query
- Fix: Quote widget inside sidebar with separated widgets
- Fix: Subscribe form allow html in content

1.6.7: 2020-01-30
- New: Posts widget - add custom option to add posts by ID
- Improvement: No longer require `allow_url_fopen` on demo install

1.6.6: 2020-01-17
- Fix: Instagram section sync
- Improvement: Widgets options cleanup

1.6.5: 2020-01-17
- Fix: Critical bug that impeded updates to be received by EDD

1.6.4: 2020-01-16
- Improvement: Update to latest Freemius SDK
- Fix: Properly check for plugin field in update action

1.6.3: 2019-12-29
- Improvement: Generate dynamic css on theme update
- Improvement: Small styles adjustments

1.6.2: 2019-12-27
- Improvement: Move Instagram settings in extension screen
- Improvement: `allow_url_fopen` notification in demos screen
- Improvement: Quote smaller image size
- Improvement: Better social icons handling in widgets
- Improvement: On demo install finish, regenerate dynamic CSS files
- Improvement: On demo install finish, purge all caches

1.6.1: 2019-11-28
- New: Instagram custom transient timeout
- New: Post metabox switch for disabling subscribe form
- Fix: Dynamic css file proper url scheme
- Fix: Woo floating bar styles

1.6.0: 2019-11-22
- New: Add new social networks
- Improvement: Enqueue global.css only in frontend
- Improvement: Posts widget enhancements
- Improvement: Posts widget put image and title in the same anchor tag

1.5.9: 2019-11-13
- New: Add new social icons
- Improvement: Support for WordPress 5.3

1.5.8: 2019-11-07
- New: Implement Mailchimp AJAX submit
- Fix: Instagram widget do not output empty images withour `src`
- Fix: Properly load dinamic styles for floating cart
- Fix: Validation error with attrs spacing

1.5.7: 2019-11-02
- Fix: Always parent theme check

1.5.6: 2019-11-01
- New: Add `wp-editor` for cookies content boxes
- New: Xing social network
- New: Implement dynamic CSS output in files
- Improvement: Quote widget option for disabling author label
- Improvement: Posts widget handling for category
- Fix: Demo install SSL issue
- Fix: Quick View modal add to cart button is not working

1.5.5: 2019-10-18
- New: Floating cart for products
- Improvement: Deactivate demo plugins on demo uninstall
- Improvement: Scope companion to sites, not whole network
- Improvement: Add theme minimum supported version
- Fix: Enable Woo wizzard back

1.5.4: 2019-10-10
- New: Improved content importer for demo install
- New: Modify demo install screen
- Improvement: Customizer sync helpers for handling `CT_CSS_SKIP_RULEDEFAULT`

1.5.3: 2019-10-02
- Fix: Properly access global classes inside namespace

1.5.2: 2019-10-01
- New: Clear cache on theme and plugin update
- New: Add shadow for Mailchimp form
- Improvement: Change class of the panel

1.5.1: 2019-09-24
- Improvement: Better animations for quick view modal

1.5.0: 2019-09-20
- New: Compatibility with Blocksy 1.5.0
- Improvement: Better handling for social icons
- Improvement: Support for responsive color picker

1.1.8: 2019-08-20
- Fix: Remove Google+ social network
- Fix: Scripts loading order, makes sure `ct-events` are always present

1.1.7: 2019-08-12
- New: Mailchimp extension customizable placeholders for fields
- Improvement: Use only one translation domain

1.1.6: 2019-08-05
- Improvement: Move user meta social networks from theme
- Fix: Small fixes in styles

1.1.5: 2019-08-01
- New: Option for changing cookies consent on forms
- Fix: `blocksy_get_colors()` call with proper defaults
- Fix: Do not focus on quantity field on quick view open
- Fix: Initialize quick view on infinite scroll load

1.1.4: 2019-07-15
- Fix: Quick view UI when not in Shop
- Fix: Cookie Notice readme for WP Fastest Cache

1.1.3: 2019-07-10
- Fix: Demo install process avoid notices

1.1.2: 2019-07-05
- Improvement: Add RSS social network to About me
- Fix: About me widget socials

1.1.1: 2019-06-30
- Fix: Proper capabilities check for extensions API

1.1.0: 2019-06-27
- New: Demo Install Engine

1.0.11: 2019-06-18
- New: Author widget
- New: Quote widget
- New: About me widget
- New: Facebook Like box widget
- Improvement: Highlight Blocksy widgets and reorder
- Improvement: Shorten Instagram transients period
- Improvement: Instagram add clear caches button
- Improvement: Type option on posts widget

1.0.10: 2019-06-05
- Improvement: Dashboard visual changes
- Fix: Properly enqueue Elementor CSS
- Fix: Instagram images glitch when lazy load is disabled

1.0.9: 2019-05-23
- New: Introduce a way for extensions to run code on activation and deactivation
- Improvement: Cookie notification integration with W3 Total Cache, WP Super Cache and WP Rocket
- Improvement: Better way to translate content in JSX
- Fix: Jetpack and Gutenberg interfering with `print_footer_scripts` hook

1.0.8: 2019-05-20
- New: WooCommerce Extra extension with Quick View button for products
- New: Add changelog for companion plugin in dashboard
- Improvement: Disable Read Progress Bar from pages
- Improvement: Improve readme.txt output for plugin updates

1.0.7: 2019-05-11
- Improvement: Move Mailchimp in footer

1.0.6: 2019-05-11
- Improvement: Use WP's global React and ReactDOM
- Improvement: Include gulpfile.js and package.json files in the final build

1.0.5: 2019-05-10
- New: EDD Integration

1.0.4: 2019-05-09
- Fix: Read progress bar check for els presence
- Fix: Small fixes for Instagram block
- Fix: Proper lazy load attributes for sync logic

1.0.3: 2019-05-02
- New: Checkbox for consent
- Improvement: Tested with WordPress 5.2
- Improvement: Support Blocksy child themes variations

1.0.2: 2019-05-01
- New: Google Analytics script
- New: Instagram extension with block and widget
- New: Allow SVG uploads
- New: Read Progress extension
- New: Mailchimp subscribe extension
- New: Cookies consent extension
- New: Elementor Columns Fix switch

1.0.1: 2019-04-11
- Improvement: Instagram widget text & defaults changes
- Fix: Remove `gz` files from build

1.0.0: 2019-04-10
- New: Initial Release
