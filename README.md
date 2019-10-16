Interview Test
==========================
It's built in symfony 4.7 and vueJs 2.

## Getting Started
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

##Prerequisites
PHP 7.1 - MSQL 5.7.17 - APACHE2
composer
git


## Installing
$ git clone https://github.com/dev-febe/InterviewTest.git
$ composer install
$ yarn install / npm install
$ php bin/console doctrine:schema:create
$ php bin/console doctrine:migration:migrate
$ yarn run dev / npm run dev

## License
This project is licensed under the MIT License.