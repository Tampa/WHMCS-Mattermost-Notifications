<?php

namespace WHMCS\Module\Notification\Mattermost;

use WHMCS\Config\Setting;
use WHMCS\Exception;
use WHMCS\Module\Notification\DescriptionTrait;
use WHMCS\Module\Contracts\NotificationModuleInterface;
use WHMCS\Notification\Contracts\NotificationInterface;

/**
 * Mattermost
 *
 * @copyright Copyright (c) Zetamex Network 2018
 * @license http://www.zetamex.com/
 */
class Mattermost implements NotificationModuleInterface
{
	use DescriptionTrait;

	public function __construct()
	{
		$this->setDisplayName('Mattermost')
			->setLogoFileName('logo.svg');
	}
	
	public function settings()
	{
		return [
			'webhook_url' => [
				'FriendlyName' => 'Webhook URL',
				'Type' => 'text',
				'Description' => 'Webhook URL created in Mattermost to send notifications to.',
			],
			'ssl' => [
				'FriendlyName' => 'SSL',
				'Type' => 'yesno',
				'Description' => 'Verify Server Certificate:<br>If your Mattermost server does not have a valid certificate notifications may not be delivered with this enabled',
			],
		];
	}
	
	public function testConnection($settings)
    {
		return true;
    }

    public function notificationSettings()
    {
        return [];
    }

    public function getDynamicField($fieldName, $settings)
    {
        return [];
    }

    public function sendNotification(NotificationInterface $notification, $moduleSettings, $notificationSettings)
    {
		
		$ch = curl_init();
		
		if ($modulesettings['ssl'] === false)
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		}
		curl_setopt($ch, CURLOPT_URL, $moduleSettings['webhook_url']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"text\": \"WHMCS Notification\n".$notification->getTitle()."\n".$notification->getMessage()."\n".$notification->getUrl()."\"}");
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$headers = array();
		$headers[] = "Content-Type: application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close ($ch);
    }
}