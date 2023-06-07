<?php

namespace gift\app\actions;

class GetPrestationAction {
	public function __invoke($request, $response, $args) {
		$html = <<<HTML
		<html lang="fr">
			<head>
				<meta charset="UTF-8">
				<title>Prestations</title>
			</head>
			<body>
				<center><h1>Prestations</h1></center>
				<h2>
					<ul>
						<li>1. <a href="/prestations/add">Ajouter une prestation</a></li>
					</ul>
				</h2>
			</body>
		</html>
		HTML;

		$response->getBody()->write($html);
		return $response;
	}
}