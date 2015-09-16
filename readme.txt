=== Plugin Name ===
Contributors: jennschiffer
Plugin Name: Featured Comment Widget
Plugin URI: http://github.com/jennschiffer/featured-comment-widget/
Author: Jenn Schiffer
Author URI: http://jennmoney.biz/
Tags: comments, featured, sidebar, comment, comment widget, showcase, commenters
Requires at least: 2.3
Tested up to: 4.3
Stable tag: 1.6

== Description ==

The Featured Comment Widget gives you the ability to shine a spotlight on some of your favorite comments on the site.

Installing this plugin adds the Featured Comment Widget to your list of available widgets in the 'Widgets' submenu (which you can find under 'Appearance' in your WordPress dashboard). Every comment has an numeric ID, and putting that ID in the widget form results in the that comment (or commentS if you enter multiple IDs), along with the name and Gravatar of its commenter, showing in the sidebar.  The Gravatar and username is automatically a link to that comment in its respective post.

== Changelog ==

= 1.7 =
* Fixes "WP_Widget deprecated" bug to work with WordPress 4.3 update.

= 1.6 =
* Allows multiple comments to be featured when entering comma-delimited comment IDs - probably the most requested feature since I created this plugin!

= 1.5 =
* Sets anonymous comment author names to "Anonymous." A million delicious Internet cupcakes for Andrew Gorry for catching and solving this in the pancake theorem blog comments!

= 1.4 = 
* Disables excerpting comments if mbstring not enabled in PHP configuration - a fancy hat tip to Allin for mentioning this error and its solution in the pancake theorem blog comments!

= 1.3 =
* Optimized permalink gets
* Added i18n .pot file for translation

= 1.2 =
* Add ability to excerpt comments by a given number of characters.

= 1.1 =
* Add ability to enter custom widget title.

== Installation ==

1. Upload `featured-comment-widget.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add the widget through the 'Widgets' submenu under 'Appearance' in WordPress
4. Add the comment ID of the comment you want featured in the widget (or multiple comma-delimited IDs) and save.

== Widget CSS ==

The following are the classes and explanations of them for those of you who want to style your widget in the custom.css file:

* .featuredComment-comment - a single comment block containing the content and citation, default: { margin: 20px auto; }
* .featuredComment-comment-content - the comment text, default: { margin: 3px auto 5px;}
* .featuredComment-cite - the citation that includes gravatar and author name, default: { display: block; text-align: left; line-height: 1em;}
* .featuredComment-gravatar - the gravatar image within citation, default: {float: right; padding: 0px 5px;}
* .featuredComment-author - the "posted by ..." author link within citation, default: {float: right;}

== Screenshots ==

1. Finding the comment ID to enter into your widget form.
2. Finding the comment ID in the Dashboard.
3. The Featured Comment Widget form.
4. This is what the widget looks like if you're using the Twenty Ten theme by WordPress.
5. This is what the widget looks like on a custom themed blog, with the comments excerpted at approximately 95 characters.
6. This is what the widget looks like on Twenty Thirteen, with multiple (3) comments showing up at once.
