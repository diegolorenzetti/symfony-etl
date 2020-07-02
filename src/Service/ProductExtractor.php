<?php

namespace App\Service;

use League\Csv\Reader;
use League\Csv\Statement;

class ProductExtractor
{

    /**
     *
     * @var string
     */
    protected $csvFile;

    public function __construct(string $csvFile)
    {
        $this->csvFile = $csvFile;
    }

    public function extract()
    {
        $reader = Reader::createFromPath($this->csvFile, 'r');
        $reader->setDelimiter(',');
        $reader->setHeaderOffset(0);
        
        //$records = $reader->getRecords();
        $stmt = (new Statement())
		    ->where(fn(array $record) => (bool) $record['PRODUCT'] != '')
		;

		$records = $stmt->process($reader);

        return $records;
    }
}