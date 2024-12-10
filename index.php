<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Product list</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
	<div class="container bg-light h-100">
		<form id="productForm" class=" pt-3">
			<div class="form-group w-50 mt-2">
				<label class="form-label" for="name">Product Name</label>
				<input type="text" class="form-control" id="name" required>
			</div>
			<div class="form-group w-50 mt-2">
				<label class="form-label" for="quantity">Stock Quantity</label>
				<input type="number" class="form-control" id="quantity" required>
			</div>
			<div class="form-group w-50 mt-2">
				<label class="form-label" for="price">Price per Item</label>
				<input type="number" class="form-control" id="price" required>
			</div>
			<button type="submit" class="btn btn-primary mt-3">Add Product</button>
		</form>
		<div class="table-container">
			<table class="table table-bordered mt-4">
				<thead>
					<tr>
						<th>Name</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Date Submitted</th>
						<th>Total Value</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="productTableBody">
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">Sum Total</td>
						<td id="sumTotal">$0.00</td>
						<td></td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</body>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Form submission
		document.getElementById('productForm').addEventListener('submit', function(e) {
			e.preventDefault();

			const name = document.getElementById('name').value;
			const quantity = document.getElementById('quantity').value;
			const price = document.getElementById('price').value;

			fetch('save.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						name,
						quantity,
						price
					})
				}).then(response => response.json())
				.then(data => {
					if (data.status === 'success') {
						// load data
						document.getElementById('productForm').reset();
					} else {
						// error
						console.log('error', data);
					}
				})
				.catch(error => console.error('Error:', error));
		});
	});
</script>

</html>
