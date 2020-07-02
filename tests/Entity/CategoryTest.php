<?php

namespace App\Tests\Entity;

use App\Entity\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public function testGetterAndSetter()
    {
        $category = new Category();
        $category->setName('Category XPTO');
        $this->assertEquals('Category XPTO', $category->getName());
    }

    public function testIsValid()
    {
        $category = new Category();
        $category->setName('Category XPTO');
        $this->assertTrue($category->isValid(), 'Category with Name is valid.');


        $category->setName('');
        $this->assertFalse($category->isValid(), 'Ctegory with empty Name is not valid.');
    }
}