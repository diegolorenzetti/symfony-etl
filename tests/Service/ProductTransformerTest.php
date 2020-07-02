<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\ProductTransformer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class productTransformerTest extends KernelTestCase
{
    public function testExtract()
    {

        $data = [
            'PRODUCT' => 'Product XPTO',
            'DESCRIPTION' => 'Description of product XPTO',
            'PRICE' => 10.00,
            'CATEGORY' => 'Category XPTO'
        ];

        $productTransformer = new ProductTransformer();
        $product = $productTransformer->transform($data);

        $this->assertInstanceOf(Product::class, $product, 'Trnasform should return a Product entity');

        $textEncoding = mb_detect_encoding($product->getName(), mb_list_encodings(), true);
        $this->assertEquals($textEncoding, 'UTF-8', 'Trnasform should return data converted to UTF-8');
    }
}