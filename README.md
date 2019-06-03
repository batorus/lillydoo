Application instalation steps:
=============================
1. clone this repository
2. check to see if the next directories were created: 
   - var/data
   - web/bundles/lillydoo/images/originals/
   - web/bundles/lillydoo/images/thumbs/

   If they weren't generated (this is a known issue), they have to be be manually created.

3. run "composer install" in the root of the application, in order for the dependencies to be installed
4. when asked for database credentials and other parameters, the application works fine with the default values.
5. in "var/data" directory create a file titled "data.sqlite"
6. run "php bin/console doctrine:migrations:diff" in the root of the application
7. if the above command was successful, run "php bin/console doctrine:migrations:migrate" in the root of the application
8. Run the application at this entry point: addressbook/
9. php version I've used for development: PHP 7.2.14; composer version:  1.8.5 ; symfony version: 3.4.28
