<?php

use GuzzleHttp\Client;
use Package\ItemCommand;
use Package\RestClient;

require 'vendor/autoload.php';

const SERVER_HOST = '127.0.0.1:8001';

$client = new RestClient(SERVER_HOST, new Client());

try {
    $availableItems = $client->getItems(true);
    $unavailableItems = $client->getItems(false);

    $newItem = $client->createItem(new ItemCommand(
        'new product',
        22
    ));

    $updatedItem = $client->updateItem($newItem->getId(), new ItemCommand(
        'new updated product 2',
        23
    ));

    $client->deleteItem($updatedItem->getId());

} catch (\Exception $e) {

}
exit;