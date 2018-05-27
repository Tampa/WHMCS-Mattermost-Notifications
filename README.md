# WHMCS-Mattermost-Notifications
Notifications module for WHMCS for Mattermost Webhooks

# Setup

-Place Mattermost.php and logo.svg inside the modules/notifications/Mattermost folder of your WHMCS Installation

-Generate an incoming webhook in Mattermost for the notifications module to use

-Navigate to the Notifications Settings in WHMCS and click Configure

-Enter the Webhook you generated within Mattermost into the webhook field

-If your Mattermost server does not have a valid certificate leave the SSL checkbox unchecked


# Further Information

Notifications are sent via the webhook using curl, curl needs to be installed for the notifications to work, please ensure you have curl installed on the machine running WHMCS!

This module may be used as template for other notification modules.
