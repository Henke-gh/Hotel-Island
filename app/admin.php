<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../nav/header.html";
?>

<main>
    <h2>Admin</h2>

    <?php

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();

    echo $_ENV['API_KEY'];

    use GuzzleHttp\Client;
    use PSpell\Config;

    $client = new Client();

    $url = "https://www.yrgopelag.se/centralbank/";

    $data = [
        'API_KEY' => '9ca1e3d1-aa16-4455-9936-739984164f40'
    ];

    $response = $client->request('POST', $url, [
        'form_params' => $data,
        'verify' => false,
    ]);

    $body = $response->getBody()->getContents();

    echo $body;
    ?>
</main>


To check if a given transfer code is valid using Composer/Guzzle in PHP, you can make a POST request to the /transferCode endpoint of the central bank API. Below is an example of how you can use Guzzle to achieve this:

First, ensure you have Guzzle installed via Composer:

bash
Copy code
composer require guzzlehttp/guzzle
Now, you can use the following code:

php
Copy code
<?php

require 'vendor/autoload.php';

//use GuzzleHttp\Client;

function checkTransferCode(string $transferCode, float $totalCost): bool
{
    // Replace 'your-api-key' with the actual API key obtained from /startCode endpoint
    $apiKey = 'your-api-key';

    $client = new Client([
        'base_uri' => 'https://www.yrgopelag.se/centralbank',
    ]);

    $response = $client->post('/transferCode', [
        'json' => [
            'transferCode' => $transferCode,
            'totalcost' => $totalCost,
        ],
        'headers' => [
            'Authorization' => 'Bearer ' . $apiKey,
        ],
    ]);

    $statusCode = $response->getStatusCode();

    return $statusCode === 200;
}

// Example usage
$transferCode = 'the-transfercode'; // Replace with the actual transfer code
$totalCost = 10; // Replace with the actual total cost

if (checkTransferCode($transferCode, $totalCost)) {
    echo 'Transfer code is valid.';
} else {
    echo 'Transfer code is invalid.';
} ?>

<?php require_once __DIR__ . "/../nav/footer.html";
