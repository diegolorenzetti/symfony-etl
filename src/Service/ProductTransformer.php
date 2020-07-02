<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Product;

class ProductTransformer
{
    public function transform($data)
    {
        $data = array_map("utf8_encode", $data);

        $category = new Category();
        $category->setName($data['CATEGORY']);

        $product = new Product();
        $product->setName($data['PRODUCT']);
        $product->setDescription($data['DESCRIPTION']);
        $product->setPrice($data['PRICE']);
        $product->setCategory($category);

        return $product;
    }
}