<?php

namespace gift\app\actions;

use gift\app\actions\AbstractAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetCategorieAction extends AbstractAction
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface
    {
        $html = <<<HTML
        <html>
        <head>
        <title>Categories</title>
        </head>
        <body>
        <h1>Categories</h1>
        <ul>
            <li>1. <a href="/gift.appli/public/categories/1">restauration</a></li>
            <li>2. <a href="/gift.appli/public/categories/2">hébergement</a></li>
            <li>3. <a href="/gift.appli/public/categories/3">attention</a></li>
            <li>4. <a href="/gift.appli/public/categories/4">activités</a></li>
        </ul></body></html>
HTML;
        $response->getBody()->write($html);
        return $response;
    }
}