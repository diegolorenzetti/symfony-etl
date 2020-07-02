<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{

    public function testGetterAndSetter()
    {
        $product = new Product();

        $this->assertNull($product->getId());

        $product->setName('Product XPTO');
        $this->assertEquals('Product XPTO', $product->getName());

        $product->setDescription('Description of product XPTO');
        $this->assertEquals('Description of product XPTO', $product->getDescription());

        $product->setPrice(10.00);
        $this->assertEquals(10.00, $product->getPrice());

        $category = new Category();
        $product->setCategory($category);
        $this->assertInstanceOf(Category::class, $product->getCategory());
    }

    public function testIsValid()
    {
        $category = new Category();
        $category->setName('Category XPTO');

        $product = new Product();
        $product->setName('Product XPTO');
        $product->setPrice(10.00);
        $product->setCategory($category);
        $this->assertTrue($product->isValid(), 'Product with all not nullable fields is valid.');


        $product->setName('');
        $this->assertFalse($product->isValid(), 'Product with no Name atribute is not valid.');
        $product->setName('Product XPTO');

        $product->setPrice(0);
        $this->assertFalse($product->isValid(), 'Product with Price zero is not valid.');
        $product->setPrice(10.00);

        //Here we ends up to test Category, maybe it's not correct
        $category->setName('');
        $this->assertFalse($product->isValid(), 'Product with no valid category is not valid.');
    }
}