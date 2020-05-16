<?php


namespace lucasgiovanny\SmsDev\Tests;

use lucasgiovanny\SmsDev\SmsDevMessage;
use Orchestra\Testbench\TestCase;

class SmsDevMessageTest extends TestCase
{


    public function testPassMessageToConstructor()
    {
        $message = new SmsDevMessage('This is my message.');
        $this->assertEquals('This is my message.', $message->getPayloadValue('msg'));
    }

    public function testCreateMessageWithCreateMethod()
    {
        $message = SmsDevMessage::create('This is my message.');
        $this->assertEquals('This is my message.', $message->getPayloadValue('msg'));
    }

    public function testMessageCanBeSet()
    {
        $message = new SmsDevMessage();
        $message->content("This is my message.");
        $this->assertEquals('This is my message.', $message->getPayloadValue('msg'));
    }

    public function testTypeEnabledByDefault()
    {
        $message = SmsDevMessage::create("This is my message.");
        $this->assertEquals(9, $message->getPayloadValue('type'));
    }

    public function testMessageCanReturnPayloadAsArray()
    {
        $message = (new SmsDevMessage('This is my message.'))
            ->to('5531992455941');

        $expected = [
            'number' => '5531992455941',
            'type' => 9,
            'msg' => 'This is my message.',
        ];

        $this->assertEquals($expected, $message->toArray());
    }
}
