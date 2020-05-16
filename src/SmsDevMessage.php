<?php


namespace lucasgiovanny\SmsDev;


class SmsDevMessage
{
    protected $payload;

    public function __construct(string $message = '')
    {
        $this->payload['msg'] = $message;
        $this->payload['type'] = '9';
    }

    public function getPayloadValue(string $key)
    {
        return $this->payload[$key] ?? null;
    }

    public static function create(string $message)
    {
        return new self($message);
    }

    public function hasToNumber(): bool
    {
        return isset($this->payload['to']);
    }

    public function toArray(): array
    {
        return $this->payload;
    }

    public function content(string $message): self
    {
        $this->payload['msg'] = $message;

        return $this;
    }

    public function to(string $to): self
    {
        $this->payload['number'] = $to;

        return $this;
    }
}
