# SMSDev notifications channel for Laravel

This package makes it easy to send notifications using [SMSDev](https://www.smsdev.com.br/) with Laravel.

<a href="https://www.buymeacoffee.com/lucasgiovanny" target="_blank"><img src="https://www.buymeacoffee.com/assets/img/custom_images/orange_img.png" alt="Buy Me A Coffee" style="height: 41px !important;width: 174px !important;box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;-webkit-box-shadow: 0px 3px 2px 0px rgba(190, 190, 190, 0.5) !important;" ></a>

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

'smsdev'  => [

'api_key'  =>  env('SMSDEV_API_KEY')

],

...

```

2. Add you API Key from [SMSDev](https://www.smsdev.com.br) to your `.env` file

## Usage

1. First you need to add the function `routeNotificationFor` in the `User` model:

```php
	public function routeNotificationFor()
	{
		return $this->phone_number; //replace with the phone number field you have in your model
	}
```

2. Now, you can use this channel by adding `SmsDevChannel::class` to the array in the `via()` method of your notification class. You need to add the `toSmsdev()` method which should return a `new SmsDevMessage()` object.

```php
<?php

namespace  App\Notifications;

use  Illuminate\Notifications\Notification;
use  lucasgiovanny\SmsDev\SmsDevChannel;
use  lucasgiovanny\SmsDev\SmsDevMessage;

class  InvoicePaid  extends  Notification
{
	public  function  via($notifiable)
	{
		return [SmsDevChannel::class];
	}

	public  function  toSmsdev() {
		return (new  SmsDevMessage('Invoice paid!'));
	}
}
```

### Available Message methods

- `getPayloadValue($key)`: Returns payload value for a given key.

- `content(string $message)`: Sets SMS message text.

- `to(string $number)`: Set manually the recipients number (international format).

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
