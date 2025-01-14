<?php

namespace App\Http\Traits;

use App\Mail\GlobalMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

trait EmailTrait
{

    /**
 * Sends an email with the given subject and content to the provided email address.
 *
 * This method uses Laravel's Mail facade to send a GlobalMail email.
 * If the email fails to send, an error message is logged.
 *
 * @param string $email The recipient's email address.
 * @param string $subject The subject of the email.
 * @param string $content The content of the email.
 * @return bool Returns true if the email was sent successfully, false if there was an error.
 */
    public function sendEmail($email, $subject, $content){
        try {
            $mailData = [
                'subject' => $subject,
                'content' => $content,
            ];
            Mail::to($email)->send(new GlobalMail($mailData));
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send email to ' . $email . ': ' . $e->getMessage());
            return false;
        }
    }


/**
 * Sends an OTP to the specified email address via an external API.
 *
 * This method sends an OTP using a POST request to an external API endpoint.
 * If the API request fails or there is an issue with the response,
 * it returns the error details.
 *
 * @param string $email The recipient's email address.
 * @param string $otp The one-time password (OTP) to be sent.
 * @return array The response from the API, either success data or error message.
 */
    function sendOtp($email, $otp)
    {
        $client = new Client();

        try {
            $response = $client->post('http://yourbestlawyer.twgdevops.com/api/send-otp', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $email,
                    'otp' => $otp,
                ],
            ]);

            $responseBody = json_decode($response->getBody()->getContents(), true);
            return $responseBody;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                return json_decode($e->getResponse()->getBody()->getContents(), true);
            }
            return ['error' => 'Failed to connect to API'];
        }
    }

}
