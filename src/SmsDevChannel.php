<?php


namespace lucasgiovanny\SmsDev;


use Illuminate\Notifications\Notification;
use lucasgiovanny\SmsDev\Exceptions\CouldNotSendNotification;

class SmsDevChannel
{
    protected $smsdev;

    public function __construct(SmsDev $smsdev)
    {
        $this->smsdev = $smsdev;
    }

    public function send($notifiable, Notification $notification)
    {

        $message = $notification->toSmsdev($notifiable);

        if (is_string($message)) {
            $message = SmsDevMessage::create($message);
        }

        if (!$message->hasToNumber()) {

            if (!$to = $notifiable->phone_number) {
                $to = $notifiable->routeNotificationFor('sms');
            }

            if (!$to) {
                throw CouldNotSendNotification::phoneNumberNotProvided();
            }

            $message->to($to);
        }

        $params = $message->toArray();


        if ($message instanceof SmsDevMessage) {
            $response = $this->smsdev->sendMessage($params);
        } else {
            return;
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}
