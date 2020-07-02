<?php

namespace App\Command;

use App\Service\ProductExtractor;
use App\Service\ProductTransformer;
use App\Service\ProductLoader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductMigrateCommand extends Command
{
    protected static $defaultName = 'product:migrate';

    /**
     * @var ProductExtractor
     */
    private $extractor;

    /**
     * @var ProductTransformer
     */
    private $transformer;

    /**
     * @var ProductLoader
     */
    private $loader;


    public function __construct(ProductExtractor $extractor, ProductTransformer $transformer, ProductLoader $loader)
    {
        $this->extractor = $extractor;
        $this->transformer = $transformer;
        $this->loader = $loader;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Migrate Products.')
            ->setHelp('This command allows you to migrate products.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $products = $this->extractor->extract();

        //dd($products);

        foreach ($products as $productData) {
            //print_r($productData);

            try {
                $product = $this->transformer->transform($productData);
                //print_r($product);
                $this->loader->load($product);
                
                $output->writeln('<info>[Success] ['.$product->getName().'] Product migrated</info>');
            } catch (\Exception $e) {
                $output->writeln('<error>[Failure] ['.$product->getName().'] '.$e->getMessage().'</error>');
            }
        }

        return Command::SUCCESS;

        // return Command::FAILURE;
    }
}