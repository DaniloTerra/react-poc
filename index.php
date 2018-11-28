<?php

require './vendor/autoload.php';

use React\Http\Server;
use React\Http\Response;
use Psr\Http\Message\ServerRequestInterface;

$loop = React\EventLoop\Factory::create();

$server = new Server(function (ServerRequestInterface $request) {
    $browser = implode($request->getHeader('User-Agent'));
    echo "Browser: $browser\n";

    $params = $request->getQueryParams();
    $name = $params['name'] ?? 'World';

    return new Response(200, ['Content-type' => 'text/plain'], "Hello, $name!");
});

$socket = new React\Socket\Server(8080, $loop);

$server->listen($socket);

echo "Listening on " . str_replace('tcp:', 'http:', $socket->getAddress() . "\n");

$loop->run();
