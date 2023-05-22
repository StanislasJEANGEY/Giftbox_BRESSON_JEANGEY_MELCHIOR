<?php

namespace gift\app\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use gift\app\services\prestations\PrestationsService as PrestationsService;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GetCategorieAction extends AbstractAction
{
    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args) : ResponseInterface {
        $prestaService = new PrestationsService();
        $categories = $prestaService->getCategories();
		$routeConext = RouteContext::fromRequest($request);
		$basePath = $routeConext->getBasePath();
		foreach ($categories as $index) {
			$url = $routeConext->getRouteParser()->urlFor('categorie', ['id' => $categories['id']]);
			$categories[$index]['url'] = $url;
		}

        /*$html = <<<HTML
        <html lang="fr">
            <head>
                <meta charset="UTF-8">
                <title>Catégories</title>
            </head>
            <body>
                <center><h1>Catégories</h1></center>
                <br>
        HTML;

        $html .= '<ul>';

        foreach ($categories as $categorie) {
            $html .= <<<HTML
                <li> {$categorie['id']} : <a href="/categories/{$categorie['id']}"> {$categorie['libelle']} </a></li>
                <br>
            HTML;
        }
        $html .= '</ul>';

        $html .= <<<HTML
            <br>
            <a href="/categories/add"><button>Ajouter une catégorie</button></a>
            </body>
        </html>
        HTML;*/

        $view = Twig::fromRequest($request);
        return $view->render($response, 'CategorieView.twig', [
            'list_categ' => $categories
        ]);

        //$response->getBody()->write($html);
        //return $response;
    }
}