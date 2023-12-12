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

<?php require_once __DIR__ . "/../nav/footer.html";
