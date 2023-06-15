<?php

namespace gift\api\actions;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetAccueilAction extends \gift\api\actions\AbstractAction
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $data = '
{
  "title": "Page d\'accueil",
  "content": [
    {
      "type": "center",
      "data": {
        "type": "h1",
        "data": "Page d\'accueil"
      }
    },
    {
      "type": "center",
      "data": {
        "type": "p",
        "data": "Bienvenue sur GiftBox"
      }
    },
    {
      "type": "center",
      "data": {
        "type": "p",
        "data": "Vous pouvez dès à présent vous connecter ou vous inscrire"
      }
    },
    {
      "type": "center",
      "data": {
        "type": "p",
        "data": "Vous pouvez également consulter les différentes box"
      }
    },
    {
      "type": "center",
      "data": {
        "type": "p",
        "data": "GiftBox est un site de vente de box cadeaux.\n\nVous pouvez acheter des box pour vous ou pour offrir.\n\nVous pouvez également créer votre propre box.\n\nVous pouvez également consulter les box déjà existantes."
      }
    }
  ]
}';
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

    }
}