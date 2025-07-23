# Comment lancer ?
## Pré-requis
- 
## Étapes
Installez d'abord les dépendances:
`composer install`
Instanciez Postgres si besoin:
`docker-compose up`
Crééz la base de données:
`php bin/console doctrine:database:create`
`php bin/console doctrine:migrations:migrate`
Et populez là:
`php bin/console doctrine:fixtures:load`
Puis lancez le serveur Symfont:
`symfony serve`
