<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products and Categories</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Products and Categories</h1>
        <div id="product-section" class="mb-5">
            <h2>Products</h2>
            <div id="products" class="row"></div>
        </div>
        <div id="category-section" class="mb-5">
            <h2>Categories</h2>
            <ul id="categories" class="list-group"></ul>
        </div>
        <div id="add-section">
            <h2>Add Product</h2>
            <form id="add-product-form">
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="number" id="price" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" class="form-select" required></select>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" id="image" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>
    </div>

    <script>
        const API_BASE = "http://127.0.0.1:8000/api";

        // Fetch and display products
        async function fetchProducts() {
            const response = await fetch(`${API_BASE}/product`);
            const products = await response.json();
            const productSection = document.getElementById('products');
            productSection.innerHTML = products.map(product => `
                <div class="col-md-4">
                    <div class="card">
                        <img src="${product.image}" class="card-img-top" alt="${product.name}">
                        <div class="card-body">
                            <h5 class="card-title">${product.name}</h5>
                            <p class="card-text">${product.description || 'No description available.'}</p>
                            <p class="card-text"><strong>Price:</strong> ${product.price}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // Fetch and display categories
        async function fetchCategories() {
            const response = await fetch(`${API_BASE}/category`);
            const categories = await response.json();
            const categoryList = document.getElementById('categories');
            const categorySelect = document.getElementById('category_id');
            
            categoryList.innerHTML = categories.map(category => `
                <li class="list-group-item">${category.name}</li>
            `).join('');

            categorySelect.innerHTML = categories.map(category => `
                <option value="${category.id}">${category.name}</option>
            `).join('');
        }

        // Add a new product
        document.getElementById('add-product-form').addEventListener('submit', async (e) => {
            e.preventDefault();

            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('description', document.getElementById('description').value);
            formData.append('price', document.getElementById('price').value);
            formData.append('category_id', document.getElementById('category_id').value);
            formData.append('image', document.getElementById('image').files[0]);

            const response = await fetch(`${API_BASE}/product`, {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();
            alert(result.message);
            fetchProducts();
        });

        // Initialize
        fetchProducts();
        fetchCategories();
    </script>
</body>
</html>
