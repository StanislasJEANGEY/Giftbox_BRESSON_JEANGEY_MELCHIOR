<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use gift\app\services\utils\CsrfService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Routing\RouteContext;
use Slim\Views\Twig;
use Slim\Psr7\UploadedFile;
use Ramsey\Uuid\Uuid;

class GetAddPrestationToCategorieAction extends AbstractAction
{
	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$prestaService = new PrestationsService();
		$prestations = $prestaService->getPrestations();

		$previousURL = $request->getHeaderLine('Referer');
		$idCategorie = "";
		$parts = explode('/', $previousURL);
		$index = array_search('categories', $parts);
		if ($index !== false && isset($parts[$index + 1])) {
			$idCategorie = $parts[$index + 1];
		}

		$routeContext = RouteContext::fromRequest($request);
		$url = $routeContext->getRouteParser()->urlFor('prestations_by_categorie', ['id' => $idCategorie]);

		$view = Twig::fromRequest($request);

		if ($request->getMethod() === 'POST') {


			$data = $request->getParsedBody();

//			// Récupérer le fichier image
//			$uploadedFiles = $request->getUploadedFiles();
//			$image = $uploadedFiles['img'] ?? null;

			try {
				CsrfService::check($data['csrf_token']);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}

//			try {
//				if ($image instanceof UploadedFile) {
//					$prestaService->addPrestationToCategorie($data, $image);
//				} else {
//					throw new PrestationsServiceException("Aucune image téléchargée.");
//				}
//			} catch (PrestationsServiceException $e) {
//				throw new HttpBadRequestException($request, $e->getMessage());
//			}
			$prestaService->addPrestationToCategorie($data);

			//return $response->withHeader('Location', $url)->withStatus(302);
		} else {
			try {
				$csrf = CsrfService::generate();
				$view->render($response, 'AddPrestationToCategorieView.twig', [
					'csrf_token' => $csrf,
					'prestations' => $prestations,
					'idCategorie' => $idCategorie
				]);
			} catch (Exception $e) {
				throw new HttpBadRequestException($request, $e->getMessage());
			}
		}

		return $response;
	}
}
