<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductLoader
{
    /**
     *
     * @var EntityManagerInterface 
     */
    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function load($product)
    {

        if (!$product->isValid()) {
            throw new \InvalidArgumentException('Missing required fields.');
        }

        $category = $this->fillExistentCategory($product->getCategory());
        $product->setCategory($category);

        $product = $this->fillExistentProduct($product);

        try{
            $this->em->persist($product->getCategory());
            $this->em->persist($product);
            $this->em->flush();
        } catch (\Exception $e) {
            throw new \InvalidArgumentException('Fail migrating product '.$product->getName()."\n".'Connection error message : '.$e->getMessage());
        }

        return true;
    }

    public function fillExistentProduct($product)
    {
        $existentProduct = $this->em->getRepository(Product::class)->findOneBy(['name' => $product->getName()]);
        
        if ($existentProduct != null) {
            //If exists override the current product with the new data to update
            $existentProduct->setName($product->getName());
            $existentProduct->setDescription($product->getDescription());
            $existentProduct->setPrice($product->getPrice());
            $existentProduct->setCategory($product->getCategory());

            $product = $existentProduct;
        }

        return $product;
    }


    public function fillExistentCategory($category)
    {
        $existentCategory = $this->em->getRepository(Category::class)->findOneBy(['name' => $category->getName()]);
        
        if ($existentCategory != null) {
            $category = $existentCategory;
        }

        return $category;
    }
}