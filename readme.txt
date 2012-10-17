=== Plugin Name ===
Contributors: jennschiffer
Plugin Name: Featured Comment Widget
Plugin URI: http://pancaketheorem.com/featured-comment-widget/
Author: Jenn Schiffer
Author URI: http://pancaketheorem.com/
Tags: comments, featured, sidebar
Requires at least: 2.3
Tested up to: 3.4.2
Stable tag: 1.4

== Description ==

The Featured Comment Widget gives you the ability to shine a spotlight on some of your favorite comments on the site.

Installing this plugin adds the Featured Comment Widget to your list of available widgets in the 'Widgets' submenu (which you can find under 'Appearance' in your WordPress dashboard). Every comment has an numeric ID, and putting that ID in the widget form results in the that comment, along with the name and Gravatar of its commenter, showing in the sidebar.  The Gravatar and username is automatically a link to that comment in its respective post.

== Changelog ==

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
4. Add the comment ID of the comment you want featured in the widget and save.

== Widget CSS ==

The following are the classes and explanations of them for those of you who want to style your widget in the custom.css file:

* .featuredComment-comment - the comment text, default: { margin: 3px auto 5px;}
* .featuredComment-cite - the citation that includes gravatar and author name, default: { display: block; text-align: left; line-height: 1em;}
* .featuredComment-gravatar - the gravatar image within citation, default: {float: right; padding: 0px 5px;}
* .featuredComment-author - the "posted by ..." author link within citation, default: {float: right;}

== Screenshots ==

1. Finding the comment ID to enter into your widget form.
2. Finding the comment ID in the Dashboard.
3. The Featured Comment Widget form.
4. This is what the widget looks like if you're using the Twenty Ten theme by WordPress.
5. This is what the widget looks like on my own custom themed blog, with the comments excerpted at approximately 95 characters.
