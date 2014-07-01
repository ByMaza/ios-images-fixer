=== iOS images fixer ===
Contributors: Bishoy
Tags: ios, iphone, thumbnails, media, images, upload
Donate link: http://bishoy.me/donate
Requires at least: 2.0.0
Tested up to: 3.9.1
Stable tag: trunk
Author: Bishoy A.
License: GPL2
License URI: http://www.gnu.org/licenses/license-list.html#GPLCompatibleLicenses

Automatically fix iOS-taken images' orientation using ImageMagic/PHP GD upon upload.

== Description ==
By default, thumbnails of photos taken by an iOS device (iPhone or iPad) are flipped 90 degrees to the left, it's a long image EXIF information story. This plugin takes care of this and fixes the uploaded images orientation's (if needed, based on EXIT data) using ImageMagic Library if available or PHP GD as a fallback. 

No settings editing required, just activate the plugin and try uploading an image from your idevice!

== Frequently Asked Questions ==
= Is there any special requirement? =
Yes, PHP GD library or ImageMagic.

== Documentation ==
No documentation needed.

= Is there any code-level modifications required? =
No, just install the plugin and continue blogging happily.

== Installation ==
1. Go to your admin area and select Plugins -> Add new from the menu.
2. Search for "iOS Images Fixer".
3. Click install.
4. Click activate.

== Changelog ==

= 1.0 =
* Initial plugin release.
