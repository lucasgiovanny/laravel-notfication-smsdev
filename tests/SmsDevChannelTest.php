<?php


namespace lucasgiovanny\SmsDev\Tests;

use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use lucasgiovanny\SmsDev\SmsDev;
use lucasgiovanny\SmsDev\SmsDevChannel;
use lucasgiovanny\SmsDev\SmsDevMessage;
use Mockery;
use Orchestra\Testbench\TestCase;

class SmsDevChannelTest extends TestCase
{
    protected $smsdev;

    protected $channel;

    protected $expectedResponse = [
        'situacao' => 'OK',
        'codigo' =>  '1',
        'id' => 'direct',
        'descricao' =>  'MENSAGEM NA FILA',
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->smsdev = Mockery::mock(SmsDev::class);
        $this->channel = new SmsDevChannel($this->smsdev);
    }

    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSmsIsSent()
    {
        $notifiable = new TestNotifiable;
        $notification = new TestSmsNotification;

        // dd($notification->toSmsdev($notifiable));

        $this->smsdev->shouldReceive('sendMessage')->once()->with([
            'type' => 9,
            'msg' => 'This is my message.',
            'number' => '5555555555',
        ])->andReturns(new Response(200, [], json_encode($this->expectedResponse)));

        $actualResponse = $this->channel->send($notifiable, $notification);

        self::assertSame($this->expectedResponse, $actualResponse);
    }
}

class TestNotifiable
{
    use Notifiable;

    public $phone_number = '5555555555';

    public function routeNotificationForSms($notification)
    {
        return $this->phone_number;
    }
}

class TestSmsNotification extends Notification
{
    public function toSmsdev($notifiable)
    {
        return new SmsDevMessage('This is my message.');
    }
}
