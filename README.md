# Employee Management System POC

### Installation
- using Local Machine
  - PHP 8.1
  - mysql 8
  - run the next commands
    ```bash
    cp .env.example .env
    ```
    ```bash
    composer install
    ```
    ```bash
    php artisan db:migrate --seed
    ```
    ```bash
    php artisan serve
    ```
  - use [API documentation](https://documenter.getpostman.com/view/26549647/2s9YC7TWzg) to start testing


### used packages
- [spatie query builder](https://spatie.be/docs/laravel-query-builder/v5/introduction) for map the query params with Eloquent Query Builder
- [laravel pint](https://laravel.com/docs/10.x/pint) for support code style by default (laravel style)
- [pest](https://pestphp.com/) for testing
