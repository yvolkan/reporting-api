# Reporting API

## Installation

1. First of clone this repo with `git clone https://github.com/yvolkan/reporting-api` command on your computer.
2. Then open terminal and go to where your folder is located.
3. Build and run project `docker-compose up -d --build` with Docker.
4. Run `docker exec -it reporting-php bash` command in a running php container.
5. Run `composer install` command; this will generate _vendor_ folder.
6. Run commands ` php artisan migrate:refresh --seed` to create tables and to test data into a database.
7. If everything is ok you can see `http://localhost:8000/api/v1/status` website on your browser.

## Login Info
Login information for access to api endpoint
Email: merchant@test.com
Password: password

## Getting Started

To get started with the Postman collections you will need to download the Postman tool from getpostman.com/postman.

With Postman installed, you can then import the files whose file location is **postman** folder into Postman and start making your requests.