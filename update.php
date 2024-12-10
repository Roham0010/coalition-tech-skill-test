<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$input = json_decode(file_get_contents('php://input'), true);

	$id = (int)$input['id'];
	$name = $input['name'];
	$quantity = (int)$input['quantity'];
	$price = (float)$input['price'];

	// todo: validations try catch etc

	$dataPath = __DIR__ . '/data.json';
	$data = file_get_contents($dataPath);
	$json = json_decode($data, true);

	if (isset($json['products'][$id])) {
		// update meta with new values
		$json['meta']['total_value'] = $json['meta']['total_value'] - ($json['products'][$id]['quantity'] * $json['products'][$id]['price']) + ($quantity * $price);
		$json['meta']['total_quantity'] = $json['meta']['total_quantity'] - $json['products'][$id]['quantity'] + $quantity;

		$json['products'][$id]['name'] = $name;
		$json['products'][$id]['quantity'] = $quantity;
		$json['products'][$id]['price'] = $price;
		$json['products'][$id]['date'] = date('Y-m-d H:i:s');

		// Update other metas
		$json['meta']['last_updated_at'] = date('Y-m-d H:i:s');
		file_put_contents($dataPath, json_encode($json));
		echo json_encode(['status' => 'success']);
	} else {
		echo json_encode(['status' => 'error', 'errors' => ['Product not found']]);
	}
}
