<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$input = json_decode(file_get_contents('php://input'), true);

	try {
		$name = $input['name'];
		$quantity = $input['quantity'];
		$price = $input['price'];

		// todo: validations check

		$data = file_get_contents('data.json');
		$json = json_decode($data, true);

		$newId = isset($json['meta']['last_inserted_id']) ? $json['meta']['last_inserted_id'] + 1 : 1;
		$now = date('Y-m-d H:i:s');

		$product = [
			'id' => $newId,
			'name' => $name,
			'quantity' => $quantity,
			'price' => $price,
			'date' => $now
		];

		$json['products'][$newId] = $product;

		// Update meta
		$json['meta']['last_inserted_id'] = $newId;
		$json['meta']['last_updated_at'] = $now;
		$json['meta']['rows_count'] = count($json['products']);
		$json['meta']['total_value'] = $json['meta']['total_value'] + ($quantity * $price);

		// For later usage!
		$json['meta']['total_quantity'] = $json['meta']['total_quantity'] + $quantity;

		file_put_contents(
			__DIR__ . '/data.json',
			json_encode($json)
		);
		echo json_encode(['status' => 'success']);
	} catch (Exception $e) {
		$errors = ['error' => $e->getMessage()];
		echo json_encode($errors);
	}
} else {
	$errors = ['method' => 'Invalid request method.'];
	echo json_encode($errors);
}
