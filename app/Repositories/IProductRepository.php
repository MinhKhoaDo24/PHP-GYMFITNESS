<?php

namespace App\Repositories;

interface IProductRepository {
    public function allProduct();
    public function featuredProducts();
    public function getProductsByCategory($id);
    public function randomProduct();
    public function findProduct($id);
    public function findByName($name);
    public function storeProduct($data);
    public function updateProduct($data, $id);
    public function softDelete($id);
    public function searchProduct($request);
    public function getAllByDanhMuc($request);
    public function filterProducts($request);
}
