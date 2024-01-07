<?php
require_once __DIR__ . "/../functions/sessionStart.php";
require_once __DIR__ . "/../functions/arrays.php";
require_once __DIR__ . "/../functions/hotelFunctions.php";
require_once __DIR__ . "/../nav/header.html";
?>

<main>
    <h2>Admin</h2>

    <?php
    echo '<pre>';
    depositFunds('Henrik', '8922a221-1125-4987-9b09-38f5e91c4ace');

    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__ . "/../");
    $dotenv->load();

    echo $_ENV['API_KEY'];

    use GuzzleHttp\Client;
    use PSpell\Config;

    $client = new Client();

    $url = "https://www.yrgopelag.se/centralbank/transferCode";

    $data = [
        'API_KEY' => '9ca1e3d1-aa16-4455-9936-739984164f40'
    ];

    $response = $client->request('POST', $url, [
        'form_params' => [
            'transferCode' => '3120666f-9894-46b9-ae34-76a0310fac20',
            'totalcost' => 15,
        ],
        'verify' => false,
    ]);

    $body = json_decode($response->getBody(), true);

    echo '<pre>';
    var_dump($body);
    ?>
</main>

<?php require_once __DIR__ . "/../nav/footer.html";
