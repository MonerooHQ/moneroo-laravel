# Moneroo Laravel SDK

The Moneroo Laravel SDK is a comprehensive library that enables Laravel developers to interact with the Moneroo Payment Orchestration service. This SDK primarily facilitates Mobile Money transactions in Africa.

## Requirements
Laravel 7.0 or higher

## Installation

You can install the package via composer:

```bash
composer require axazara/moneroo-laravel
```

### Installation Command
The package provides a convenient command to install the Moneroo Laravel SDK and publish its configuration to your Laravel project. After you've installed the package via composer, you can run this command:
    
```bash
php artisan moneroo:install
```

This command will:

1. Publish a `moneroo.php` file in your config directory
2. Append your `.env` file with the `MONEROO_PUBLIC_KEY` and `MONEROO_SECRET_KEY` variables if they don't already exist.

You will have to replace 'your-public-key' and 'your-secret-key' with your actual Moneroo public key and secret key respectively.
```env

MONEROO_PUBLIC_KEY=your-public-key
MONEROO_SECRET_KEY=your-secret-key
```

Please keep in mind that these are sensitive keys and should not be publicly exposed. Laravel .env file is ignored by Git, which makes it a good place to store sensitive information.

## Payment

The `Payment` class provides methods for creating, verifying, retrieving, and marking payments as processed. You can use it like so:

### Create Payment

To create a payment, you need to pass an array of payment data to the `create` method. 
The array must contain the following keys:

Here are the required fields in a table format:

| Field Name          | Type    | Required | Description                        |
|---------------------|---------|----------|------------------------------------|
| `amount`            | integer | Yes      | The payment amount.                |
| `currency`          | string  | Yes      | The currency of the payment.       |
| `description`       | string  | No**     | Description of the payment.        |
| `customer.email`    | string  | Yes      | Customer's email address.          |
| `customer.first_name` | string  | Yes      | Customer's first name.             |
| `customer.last_name` | string  | Yes      | Customer's last name.              |
| `callback_url`      | string  | Yes      | Callback URL for payment updates.  |
| `customer.phone`    | string  | No**     | Customer's phone number.           |
| `customer.address`  | string  | No**     | Customer's address.                |
| `customer.city`     | string  | No**     | Customer's city.                   |
| `customer.state`    | string  | No**     | Customer's state.                  |
| `customer.country`  | string  | No**     | Customer's country.                |
| `customer.zip`      | string  | No**     | Customer's zip code.               |
| `metadata`          | array   | No       | Additional data for the payment.   |
| `methods`           | array  | No***    | Allowed payment methods.           |

> ** If not provided, the customer will be prompted to enter these details during the payment process.
> *** Should be an array of strings.
 If not provided, all available payment methods will be allowed.
 Array should contain only supported payment methods,
 please check the [Moneroo API documentation](https://docs.moneroo.io) for more information.

#### Example Usage

```php
$paymentData = [
    'amount' => 100,
    'currency' => 'USD',
    'customer' => [
        'email' => 'john.doe@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '123456789',
        'address' => '123 Main St',
        'city' => 'Los Angeles',
        'state' => 'CA',
        'country' => 'USA',
        'zip' => '90001',
    ],
    'description' => 'Payment for order #123',
    'callback_url' => 'https://yourwebsite.com/thanks',
    'metadata' => [
        'order_id' => '123',
        'customer_id' => '456',
    ],
    'methods' => ['card', 'orange_ci'],
];

$payment = MonerooPayment::create($paymentData);

// Redirect the customer to the Checkout URL
header('Location: ' . $payment->checkout_url);

```

The `create` method returns an object containing the payment details, including the transaction ID, Checkout URL where yous should redirect the customer to complete the payment.
You can use this transaction ID to verify the payment later on.

### Verify Payment

You can verify a payment by its transaction ID.
This is useful when you want to check the status of a payment before processing an order on your end.

```php
$transactionId = 'your-payment-transaction-id';

$payment = MonerooPayment::verify($transactionId);
```

### Retrieve Payment

To get details of a payment, use the `get` method with the transaction ID.

```php
$transactionId = 'your-payment-transaction-id';

$payment = MonerooPayment::get($transactionId);
```

### Mark Payment as Processed

This method is useful when you want to mark a payment as processed after you've received a successful callback from the Moneroo API, and you've processed the order on your end.
This will also allow you to prevent duplicate orders or store transactions IDs in your database for future reference.

> This is currently an experimental feature, please use with caution and report any issues you encounter.

To mark a payment as processed, use the `makeAsProcessed` method with the transaction ID.

Example usage:

```php
$transactionId = 'your-payment-transaction-id';

$payment = MonerooPayment::markAsProcessed($transactionId);
```

## Payout

The `Payout` class extends the main `Moneroo` class and provides methods for creating, verifying, and retrieving payouts.

### Create Payout

To create a payout, you need to pass an array of data that meets the specified validation rules.
The array must contain the following keys:

Here are the required fields in a table format:

| Field Name             | Type    | Required | Description                                        |
|------------------------|---------|----------|----------------------------------------------------|
| `amount`               | integer | Yes      | The payout amount.                                 |
| `currency`             | string  | Yes      | The currency of the payout.                        |
| `description`          | string  | No**     | Description of the payout.                         |
| `customer.email`       | string  | Yes      | Customer's email address.                          |
| `customer.first_name`  | string  | Yes      | Customer's first name.                             |
| `customer.last_name`   | string  | Yes      | Customer's last name.                              |
| `callback_url`         | string  | Yes      | Callback URL for payout updates.                   |
| `customer.phone`       | string  | No       | Customer's phone number.                           |
| `customer.address`     | string  | No       | Customer's address.                                |
| `customer.city`        | string  | No       | Customer's city.                                   |
| `customer.state`       | string  | No       | Customer's state.                                  |
| `customer.country`     | string  | No       | Customer's country.                                |
| `customer.zip`         | string  | No       | Customer's zip code.                               |
| `metadata`             | array   | No       | Additional data for the payout.                    |
| `method`               | string  | No**     | Payout methods                                     |
| `request_confirmation` | bool    | No***    | If you want to require confirmation from customer. |

>In addition to the above informations, you need to add payout methods required fields for account details.
> For exemple, if payment method is 'mtn_bj', you should provide 'phone' fields.
> This is different from user information, it account where money will be paid.
> 
> For more information, please check the [Moneroo API documentation](https://docs.moneroo.io) for more information.


> ** Should be a Moneroo supported payout method.
Please check the [Moneroo API documentation](https://docs.moneroo.io) for more information.

> *** This feature is currently in experimental phase and not available for all users/apps. 
It enables you to seek a customer's confirmation before proceeding with the payout. 
Moneroo will dispatch an email to the customer containing a confirmation code. 
The customer will then be directed to a confirmation page where they can review the payout amount and account information. 
If the details are correct, the customer can enter the confirmation code to approve the payout request or otherwise reject it. 
This function serves as a valuable tool in preventing misinformation or fraudulent operations. 
If the user does not respond within 15 minutes, the payout request will be automatically cancelled.

```php
$payoutData = [
    'amount' => 100,
    'currency' => 'USD',
    'customer' => [
        'email' => 'john.doe@example.com',
        'first_name' => 'John',
        'last_name' => 'Doe',
        // other customer details...
    ],
    'description' => 'Payout for order #123',
    'method' => 'bank_transfer',
    // other data...
];

$payout = \Moneroo\Payout::create($payoutData);
```

The `create` method returns an object containing the payout details,
including the transaction ID, and the payout status.
You can use this transaction ID to verify the payout later on.

### Verify Payout

You can verify a payout by its transaction ID.

```php
$transactionId = 'your-payout-transaction-id';

$payout = \Moneroo\Payout::verify($transactionId);
```

### Retrieve Payout

To get details of a payout, use the `get` method with the transaction ID.

```php
$transactionId = 'your-payout-transaction-id';

$payout = \Moneroo\Payout::get($transactionId);
```

Example usage:

```php
$payout = new \Axazara\MonerooLaravel\Payout;
$response = $payout->get('your-payout-transaction-id');
```

## Exception Handling

The SDK comes
bundled with several custom exceptions
to help you handle any potential errors that might arise during the use of the Moneroo API.
These exceptions are:

- **InvalidPayloadException.php**: This exception is thrown when the payload sent to the API does not meet the expected criteria.

- **ForbiddenException.php**: This exception is thrown when an action is attempted that the authenticated user does not have the necessary permissions for.

- **InvalidResourceException.php**: This exception is thrown when a request is made to a non-existent or invalid resource.

- **ServerErrorException.php**: This exception is thrown when there is an error on the server's side.

- **NotAcceptableException.php**: This exception is thrown when the client request's content characteristics are not acceptable according to the Accept headers sent in the request.

- **ServiceUnavailableException.php**: This exception is thrown when the service is currently unavailable, perhaps due to maintenance or load issues on the server.

- **UnauthorizedException.php**: This exception is thrown when the request lacks valid authentication credentials for the target resource.

For each exception, you can access the error message by calling `$exception->getMessage()`, and the error code (if available) by calling `$exception->getCode()`.


## Security Vulnerabilities

If you discover a security vulnerability within Moneroo Laravel SDK, please send an e-mail to Moneroo Security via [security@moneroo.com](mailto:security@moneroo.com). All security vulnerabilities will be promptly addressed.

## License

The Moneroo Laravel SDK is open-sourced software licensed under the [MIT license](LICENSE.md).
