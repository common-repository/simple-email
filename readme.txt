=== Simple Email ===
Contributors: jwwest
Donate link: http://thefuturewithjetpacks.com/
Tags: email, amazon, wp_mail
Requires at least: 3.0.5
Tested up to: 3.1
Stable tag: trunk

Reconfigures WordPress' WP_Mail function to use Amazon's Simple Email Service.

== Description ==

Simple Email reconfigures WordPress' WP_Mail function to use Amazon's Simple Email Service [http://aws.amazon.com/ses/](http://aws.amazon.com/ses/).

Known limitations (your mileage may vary):

* Does not support attachments
* Emails will no longer come from `wordpress@yourdomain.com` but from the authenticated address (see installation)

Thank you to [Dan Myers](http://www.orderingdisorder.com/aws/ses/) for the SES library used.

== Installation ==

1. Upload files to `/wp-content/plugins` directory
1. Edit `simple-email.php` and add your AWS API key and secret
1. You must also provide a previously authenticated email address to use as the From address 
1. Activate the plugin through the 'Plugins' menu in WordPress

== Changelog ==

= 0.1 =
* Initial release
