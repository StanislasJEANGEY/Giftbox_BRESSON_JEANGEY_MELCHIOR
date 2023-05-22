<?php

namespace gift\app\actions;

use Exception;
use gift\app\services\prestations\PrestationsService;
use gift\app\services\prestations\PrestationsServiceException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetUpdatePrestationAction extends AbstractAction {

	/**
	 * @throws Exception
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
		if (!isset($args['id'])) {
			throw new PrestationsServiceException("L'id n'existe pas", 400);
		}
		$id = $args['id'];
		$prestaService = new PrestationsService();
		$prestation = $prestaService->getPrestationById($id);
		$categories = $prestaService->getCategories();
		if ($request->getMethod() === 'POST') {
			$prestaService->getUpdatePrestation($id, $request->getParsedBody());
			header('Location: /categories');
			exit();
		}
		$html = <<<HTML
		<html lang="fr">
			<head> 
			    <meta charset="UTF-8">
				<title>Modifier une prestation</title>
			</head>
			<body>
				<center><h1>Modifier une prestation</h1></center>
				<br>
				<form action=/prestations/{$prestation['id']} method=post>
					<label for=libelle>Libelle</label>
					<input type=text name=libelle id=libelle value={$prestation['libelle']}>
					<br>
					<label for=description>Description</label>
					<input type=text name=description id=description value={$prestation['description']}>
					<br>
					<label for=prix>Prix</label>
					<input type=text name=prix id=prix value={$prestation['tarif']}>
					<br>
					<label for=categorie>Catégorie</label>
					<select name=categorie id=categorie>
						<option value={$prestation['cat_id']}>{$prestation['cat_id']}</option>
		HTML;
		foreach ($categories as $categorie) {
			$html .= "<option value={$categorie['id']}>{$categorie['libelle']}</option>";
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