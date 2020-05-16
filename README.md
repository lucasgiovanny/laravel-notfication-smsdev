# SMSDev notifications channel for Laravel

This package makes it easy to send notifications using [SMSDev](https://www.smsdev.com.br/) with Laravel.

## Contents

- [Installation](#installation) - [Setting up the SMSDev service](#setting-up-the-SMSDev-service)
- [Usage](#usage) - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

This package can be installed via composer:

`composer require lucasgiovanny/laravel-notification-smsdev`

### Setting up the SMSDev service

1. Add the API key to the `services.php` config file:

   ```php
   // config/services.php
   ...
   'smsdev' => [
   	'api_key' => env('SMS77_API_KEY')
   ],
   ...
   ```

## Usage

You can use this channel by adding `SmsDevChannel::class` to the array in the `via()` method of your notification class. You need to add the `toSmsdev()` method which should return a `new SmsDevMessage()` object.

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use lucasgiovanny\SmsDev\SmsDevChannel;
use lucasgiovanny\SmsDev\SmsDevMessage;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [SmsDevChannel::class];
    }

    public function toSmsdev() {
        return (new SmsDevMessage('Invoice paid!'));
    }
}
```

### Available Message methods

- `getPayloadValue($key)`: Returns payload value for a given key.
- `content(string $message)`: Sets SMS message text.
- `to(string $number)`: Set recipients number (international format).

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ composer test
```

## Security

If you discover any security related issues, please email lucasgiovanny@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Lucas Giovanny](https://github.com/lucasgiovanny)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
