<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetUpdatePrestationAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		$id = $args['id'];
		$prestaService = new PrestationsService();
		$prestation = $prestaService->getUpdatePrestation($id, $request->getParsedBody());
		$categories = $prestaService->getCategories();
		$html = <<<HTML
		<html>
			<head>
				<title>Modifier une prestation</title>
			</head>
			<body>
				<center><h1>Modifier une prestation</h1></center>
				<br>
				<form action=\"/prestations/{$prestation['id']}\" method=\"post\">
					<label for=\"libelle\">Libelle</label>
					<input type=\"text\" name=\"libelle\" id=\"libelle\" value=\"{$prestation['libelle']}\">
					<br>
					<label for=\"description\">Description</label>
					<input type=\"text\" name=\"description\" id=\"description\" value=\"{$prestation['description']}\">
					<br>
					<label for=\"prix\">Prix</label>
					<input type=\"text\" name=\"prix\" id=\"prix\" value=\"{$prestation['prix']}\">
					<br>
					<label for=\"categorie\">Catégorie</label>
					<select name=\"categorie\" id=\"categorie\">
					<option value=\"{$prestation['categorie_id']}\">{$prestation['categorie_id']}</option>";
		HTML;
		foreach ($categories as $categorie) {
			$html .= "<option value=\"{$categorie['id']}\">{$categorie['libelle']}</option>";
		}
		$html .= <<<HTML
					</select>
					<br>
					<button type="submit">Valider</button>
				</form>
			</body>
		</html>
		HTML;

		$response->getBody()->write($html);
		return $response;
	}
}