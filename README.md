mcmakler
========

#Teck stack:
php7, symfony3.3, mysql

#The command to import data:

./bin/console nasa:data:get

Implementation: (AppBundle\Command\GetNasaData)

#There are services:
1. Nasa client (AppBundle\Service\NasaClient) that is responsible for data importing
2. NasaObjectMapper (AppBundle\Service\NasaObjectMapper) that is responsible for mapping data to our structure
3. Nasa service (AppBundle\Service\NasaService) that is responsible for fetching nasa data from the database
