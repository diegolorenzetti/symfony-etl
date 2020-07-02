<?php

namespace App\Tests\Service;

use App\Service\ProductExtractor;
use League\Csv\ResultSet;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ProductExtractorTest extends KernelTestCase
{
    /**
     * @var string
     */
    private $csvFile;


    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->csvFile = $kernel->getContainer()
            ->getParameter('product_csv_file');
    }

    public function testExtract()
    {
        $productExtractor = new ProductExtractor($this->csvFile);

        $records = $productExtractor->extract();

        $this->assertInstanceOf(ResultSet::class, $records, 'Extract should return a ResultSet');

        $record = $records->getIterator()->current();
        $this->assertArrayHasKey('PRODUCT', $record, 'Should have PRODUCT property');
        $this->assertArrayHasKey('DESCRIPTION', $record, 'Should have DESCRIPTION property');
        $this->assertArrayHasKey('PRICE', $record, 'Should have PRICE property');
        $this->assertArrayHasKey('CATEGORY', $record, 'Should have CATEGORY property');
    }
}