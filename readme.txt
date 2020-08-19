=== eko Wordpress Plugin ===
Contributors: deanshmuel
Tags: eko, embed, embedding, interactive, video, videos, episode, episodes
Requires at least: 4.5
Tested up to: 5.4.2
Requires PHP: 5.6
Stable tag: 0.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed and manage eko interactive videos seamlessly into your Wordpress site.

== Description ==

Use the eko Wordpress Plugin to take full control of your eko interactive content.

**Store your videos** We created a custom post type for you to store and preview your interactive videos.

**Easily embed your videos** Embedding your eko content made easy with this plugin utilizing the powers of the [eko-js-sdk](https://www.npmjs.com/package/eko-js-sdk)

**Show your videos anywhere** Using shortcodes to embed your eko episode in any post type.

== Features ==
* Simple & Intuitive
* Heavy-lifting is done for you

= Links =
* [Website](https://eko.com/)
* [Dev portal](https://developer.eko.com/)
* [Studio](https://studio.eko.com/tool)

== Installation ==

From your WordPress dashboard

1. **Visit** Plugins > Add New
2. **Search** for "eko-video"
3. **Activate** Advanced Custom Fields from your Plugins page
4. **Click** on the new menu item "eko-Videos" and create your video page
5. **Enter** the video's Id to automatically fetch the video's data and content



== Frequently Asked Questions ==

Soon...

== Screenshots ==

Soon...

== Changelog ==

= 1.0 =
* The Plugin is alive!
* can create episodes and fetch content
* integrate eko interactive content in any post using shortcodes

== Embedding eko Video In every post ==

You can use the plugin's built-in shortcode to embed your eko Video in any kind of post.

**How To Use It?**
* Basic: [eko-video id=<eko video's Id>], example: [eko-video id=MebL1z]
* Make it full screen by passing full_screen=true as a parameter
* Control the iframe's dimentions by passing width and height parameters
* By default, the embedded video is reponsive. You can override it by passing responsive=false
* Example: [eko-video id=MebL1z width=800px height=600px responsive=false]

== Viewing a Single Video ==

Though eko-videos can be seamlessly embedded within any Wordpress post using shorcodes, it is adviced to create custom templates in your theme to embed eko-videos (for example: create single-eko-video.php template to render a single eko-video post).
The plugin is provided with a set of API methods to help you as a developer to embed your eko-video in your site the way you intended.
To help you get started, the plugin is provided that includes a template for a single eko video, where several of the plugin's API methods are being used.

The template is a suggestion showing you how to utilize the plugin to gain max-control over your embedded eko-content.

**How To Use It?**
1. **Copy** the provided theme folder into your site's theme directory
3. **Activate** the theme
4. **Preview** any of your eko-Video posts

== Changelog ==
 
= 1.0.3 =
* Improved readme
* Extended embedding Features
* Various bugs fixes
 