# ETL example using Symfony 5

## Documentation

Using ETL services means defining 3 services: an extractor to get the data from a source, a transformer to adapt the data to its new use and a loader to update or create the data in the target, each services passing the data to the next one.

In this example I'll handle the migration of Products from a CSV file.

The CSV contain Product Name, Description, Price and Category that will be imported to separate Entity.

Because I use ETL I already know how the command will work:

- I start by loading the 3 services in the console command ```php bin/console product:migrate```
- I extract the data using an extract() method from the extractor.
- I'll load all records to process;
- I'll iterate the records and do the following:
- Transforming the data with a transform($data) method from the transformer.
- Loading the data with a load($product) method from the loader.
- Outputing a nice success message and go on to the next record.
- If this process fail, I catch the error and output a faillure message. Then I go on to the next record.

The files that I used are:

- [src/Command/ProductMigrateCommand.php](src/Command/ProductMigrateCommand.php): Command to run our products migration
- [src/Service/ProductExtractor.php](src/Service/ProductExtractor.php): our extractor
- [src/Service/ProductTransformer.php](src/Service/ProductTransformer.php): our transformer
- [src/Service/ProductLoader.php](src/Service/ProductLoader.php): our loader
- [src/Entity/Product.php](src/Entity/Product.php): the Product entity
- [src/Entity/Category.php](src/Entity/Category.php): the category entity
- [csv/product.csv](csv/product.csv): the csv file
- [config/services.yaml](config/services.yaml): changed to configure our csv file as parameter of our extractor service
- [tests/](tests/): all unit tests


## Sources

- https://blog.theodo.com/2013/10/how-to-import-export-data-with-an-etl-command-using-symfony2-in-tdd/
- https://codereviewvideos.com/course/how-to-import-a-csv-in-symfony
- https://csv.thephpleague.com/9.0/