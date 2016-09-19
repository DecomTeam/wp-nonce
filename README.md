# Decom WPNonce

Simple WordPress Nonce object.

## Table Of Contents

* [Installation](#installation)
* [Usage](#usage)
* [License](#license)
* [Contributing](#contributing)

## Installation

The best way to use this package is through Composer:

```BASH
$ composer require decom/wp-nonce
```

Run the tests:

```sh
$ vendor/bin/phpunit
```

### Requirements

This package requires PHP 5.4 or higher.

## Usage

```php
<?php

use Decom\WPNonce\Nonce;

// create nonce object
$nonce = new Nonce($nonce_action = -1, $nonce_name = '_wp_nonce');

// get nonce url
$url = $nonce->url($base_url);

// get nonce form field
$field = $nonce->field($referer = false, $echo = false);

// get nonce value
$value = $nonce->value();

// check admin referer
$nonce->verify_admin();

// check ajax referer
$nonce->verify_ajax();

// verify nonce
$nonce->verify($value);

// nonce are you sure message
$nonce->ays();
```

## License

Copyright (c) 2016 Decom

Good news, this plugin is free for everyone! Since it's released under the [MIT License](LICENSE) you can use it free of charge on your personal or commercial website.

## Contributing

All feedback / bug reports / pull requests are welcome.
