<?php

namespace App\Tests\Service;

use App\Entity\Category;
use App\Entity\Product;
use App\Service\ProductLoader;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductLoaderTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testLoad()
    {
        $category = new Category();
        $category->setName('dairy');
        
        $product = new Product();
        $product->setName('Brown eggs');
        $product->setDescription('Raw organic brown eggs in a basket');
        $product->setPrice(28.1);
        $product->setCategory($category);

        
        $productLoader = new ProductLoader($this->entityManager);


        $result = $productLoader->load($product);
        $this->assertTrue($result, 'Valid product should return true');
        

        $product->setName('');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Missing required fields.');

        $productLoader->load($product);
    }

    public function testFillExistentProduct()
    {
        $productLoader = new ProductLoader($this->entityManager);


        //Existent Product (same name) with different values
        $category = new Category();
        $category->setName('new category value');

        $product = new Product();
        $product->setName('Brown eggs');
        $product->setDescription('new description');
        $product->setPrice(12.3);
        $product->setCategory($category);

        $existentProduct = $productLoader->fillExistentProduct($product);

        $this->assertNotNull($existentProduct->getId(), 'Existent product should have ID');
        $this->assertEquals(
            $product->getName(),
            $existentProduct->getName(),
            'Existent product should have same Name'
        );
        $this->assertEquals(
            $product->getDescription(),
            $existentProduct->getDescription(),
            'Existent product should have new Description'
        );
        $this->assertEquals(
            $product->getPrice(),
            $existentProduct->getPrice(),
            'Existent product should have new Price'
        );
        $this->assertEquals(
            $product->getCategory()->getName(),
            $existentProduct->getCategory()->getName(),
            'Existent product should have new Category Name'
        );



    

        //New Product
        $category = new Category();
        $category->setName('new category value');

        $product = new Product();
        $product->setName('new product name');
        $product->setDescription('new description');
        $product->setPrice(12.3);
        $product->setCategory($category);

        $existentProduct = $productLoader->fillExistentProduct($product);

        $this->assertNull($existentProduct->getId(), 'New product should have no ID');
        $this->assertEquals(
            $product->getName(),
            $existentProduct->getName(),
            'New product should have new Name'
        );
        $this->assertEquals(
            $product->getDescription(),
            $existentProduct->getDescription(),
            'New product should have new Description'
        );
        $this->assertEquals(
            $product->getPrice(),
            $existentProduct->getPrice(),
            'New product should have new Price'
        );
        $this->assertEquals(
            $product->getCategory()->getName(),
            $existentProduct->getCategory()->getName(),
            'New product should have new Category Name'
        );
    }
}