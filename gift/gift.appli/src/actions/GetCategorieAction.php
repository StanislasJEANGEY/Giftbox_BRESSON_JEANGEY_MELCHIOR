<?php

namespace gift\appli\action;

class GetCategorieAction extends Slim\App
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $html = <<<HTML
            <html>
            <head>
            <title>GetCategorieAction</title>
            </head>
            <body>
            <h1>GetCategorieAction</h1>
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