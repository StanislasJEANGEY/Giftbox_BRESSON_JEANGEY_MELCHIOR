<?php
use Slim\App;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

return function (App $app) {
    $app->get('../scripts/td1.php', function (Request $request, Response $response, array $args) {
        $response->getBody()->write("Hello world!");
        return $response;
    });

    /**
     * Question 1
     */
    $app->get('/categories[/]', function (Request $request, Response $response, array $args) {
        $html = <<<HTML
        <html>
        <head>
        <title>Categories</title>
        </head>
        <body>
        <h1>Categories</h1>
        <ul>
            <li>1. <a> href="/categories/1">restauration</a></li>
            <li>2. <a> href="/categories/2">hébergement</a></li>
            <li>3. <a> href="/categories/3">attention</a></li>
            <li>4. <a> href="/categories/3">activités</a></li>
        </ul></body></html>
HTML;
        $response->getBody()->write($html);
        return $response;
    });
};