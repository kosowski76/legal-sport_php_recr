  # legal-sport_php_recr


 ## Kolejność wykonywanych czynności:

   1. Skonfiguruj Docker dla projektu
   2. Zainstaluj Symfony i utwórz nowy projekt
   3. Stwórz bazę danych oraz encje
   4. Dodaj kontrolery z odpowiednimi endpointami
   5. Utwórz testy jednostkowe
   6. Uruchom i przetestuj aplikację w Docker


 ## Getting started

   $ make make-init
   $ make docker-build
   $ make docker-up

   $ make docker-test
   the same like in container: $ bash ./.docker/docker-test.sh  


 schema-update:
	
   $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="php bin/console doctrine:database:create --if-not-exists"  
    	
   $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="php bin/console doctrine:schema:update --force"  


   $ make composer ARGS="require doctrine/doctrine-migrations-bundle"  
   $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="php bin/console make:migration"  


   $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="./vendor/bin/phpunit"  
   $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="./vendor/bin/phpunit --coverage-text"  
   $ make test


 1. Entry POST: 
 
    POST 127.0.0.1:8080/entries
 {
    "id": 1,
    "name": "Entry_1",
    "category": "category_1",
    "date": "03-07-2024"
}

    POST 127.0.0.1:8080/entries
{
    "id": 2,
    "name": "Entry_2",
    "category": "category_2",
    "date": "03-07-2024"
}

2. Entry GET:

   GET 127.0.0.1:8080/entries/

3. Entry GET:

   GET 127.0.0.1:8080/entries/1

   GET 127.0.0.1:8080/entries/2


### 03. Tests

 $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="php bin/console --env=test doctrine:database:create --if-not-exists"  
 $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="php bin/console --env=test doctrine:schema:update --force"  
 $ make execute-in-container DOCKER_SERVICE_NAME="application" COMMAND="php bin/console --env=test doctrine:fixtures:load"  

 $ make test

