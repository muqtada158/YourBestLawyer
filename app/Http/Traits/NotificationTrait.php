<?php

namespace App\Http\Traits;

use onesignal\client\api\DefaultApi;
use onesignal\client\Configuration;
use onesignal\client\model\Notification;
use onesignal\client\model\StringMap;
use GuzzleHttp;

trait NotificationTrait
{
    public function sendNotification($ExternalId, $body, $image = null, $url = null)
    {
        $appId = config('services.onesignal.APPID');
        $appKeyToken = config('services.onesignal.APPKEYTOKEN');
        $userKeyToken = config('services.onesignal.USERKEYTOKEN');

        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($appKeyToken)
            ->setUserKeyToken($userKeyToken);

        $apiInstance = new DefaultApi(new GuzzleHttp\Client(), $config);

        // Check if $body is an array and extract heading and content
        if (is_array($body) && isset($body['heading']) && isset($body['content'])) {
            $title = $body['heading']; // Extract heading
            $contentText = $body['content']; // Extract content
        } else {
            // Fallback if $body is not an array, assume it's plain text content
            $title = 'YourBestLawyer.com'; // Default heading
            $contentText = $body; // Use body directly as content
        }

        // Create content (body)
        $content = new StringMap();
        $content->setEn($contentText); // Body text (detail)

        // Create heading (title)
        $heading = new StringMap();
        $heading->setEn($title); // Title text

        // Set up the notification
        $notification = new Notification();
        $notification->setAppId($appId);
        $notification->setContents($content); // Set body (detail)
        $notification->setHeadings($heading); // Set title (heading)

        // Handling External IDs
        if ($ExternalId !== null && count($ExternalId) > 0) {
            $convertedExternalId = array_map('strval', $ExternalId);
            $notification->setIncludeExternalUserIds($convertedExternalId);
            $notification->setChannelForExternalUserIds('push');
        } else {
            $notification->setIncludedSegments(['Total Subscriptions']);
        }

        // Handling Image
        if ($image !== null) {
            $notification->setBigPicture($image); // For Android big picture
            $notification->setChromeWebImage($image); // For Chrome Web Push
            $notification->setIosAttachments(json_encode(['id1' => $image])); // For iOS
        }

        // Setting URL for redirection
        // $notification->setUrl($url ?? url('/'));
        $notification->setUrl(null);

        // Android-specific settings
        $notification->setAndroidChannelId(config("services.onesignal.ANDROIDCHANNELID")); // Ensure channel ID exists in OneSignal
        $notification->setPriority(10); // Set high priority for Android notifications

        // Send Notification
        $result = $apiInstance->createNotification($notification);
        return response()->json(['status' => '1'], 200);
    }

    public function sendNotificationChat($ExternalId, $body, $image = null, $url = null, $sender = null,$sender_user_details = null)
    {
        $appId = config('services.onesignal.APPID');
        $appKeyToken = config('services.onesignal.APPKEYTOKEN');
        $userKeyToken = config('services.onesignal.USERKEYTOKEN');

        $config = Configuration::getDefaultConfiguration()
            ->setAppKeyToken($appKeyToken)
            ->setUserKeyToken($userKeyToken);

        $apiInstance = new DefaultApi(new GuzzleHttp\Client(), $config);

        // Check if $body is an array and extract heading and content
        if (is_array($body) && isset($body['heading']) && isset($body['content'])) {
            $title = $body['heading']; // Extract heading
            $contentText = $body['content']; // Extract content
        } else {
            // Fallback if $body is not an array, assume it's plain text content
            $title = 'YourBestLawyer.com'; // Default heading
            $contentText = $body; // Use body directly as content
        }

        // Create content (body)
        $content = new StringMap();
        $content->setEn($contentText); // Body text (detail)

        // Create heading (title)
        $heading = new StringMap();
        $heading->setEn($title); // Title text

        // Set up the notification
        $notification = new Notification();
        $notification->setAppId($appId);
        $notification->setContents($content); // Set body (detail)
        $notification->setHeadings($heading); // Set title (heading)


        // Check if sender is provided and get user details
        $senderData = $sender ? $sender->toArray() : null;
        $userDetails = $sender_user_details ? $sender_user_details->toArray() : null;

        // Combine sender data and user details into one array
        $combinedData = [
            'sender' => $senderData,
            'user_details' => $userDetails,
            'screen' => 'message',
            'message' => $contentText,
        ];
        $notification->setData($combinedData); // Include both sender and user details in the notification


        // Handling External IDs
        if ($ExternalId !== null && count($ExternalId) > 0) {
            $convertedExternalId = array_map('strval', $ExternalId);
            $notification->setIncludeExternalUserIds($convertedExternalId);
            $notification->setChannelForExternalUserIds('push');
        } else {
            $notification->setIncludedSegments(['Total Subscriptions']);
        }

        // Handling Image
        if ($image !== null) {
            $notification->setBigPicture($image); // For Android big picture
            $notification->setChromeWebImage($image); // For Chrome Web Push
            $notification->setIosAttachments(json_encode(['id1' => $image])); // For iOS
        }

        // Setting URL for redirection
        // $notification->setUrl($url ?? url('/'));
        $notification->setUrl(null);

        // Android-specific settings
        $notification->setAndroidChannelId(config("services.onesignal.ANDROIDCHANNELID")); // Ensure channel ID exists in OneSignal
        $notification->setPriority(10); // Set high priority for Android notifications

        // Send Notification
        $result = $apiInstance->createNotification($notification);
        return response()->json(['status' => '1','notification'=>$notification], 200);
    }
}
