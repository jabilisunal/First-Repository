# Bridge Proxy Services

## Development

### Run Development
    php artisan serve --port 8000

### Install Application
    php artisan app:install

## Deployment

#### 1. Clone Github
    git clone https://github.com/bbeycanov/myselftravel.git

#### 2. Copy .env file and Add production credentials
    cp .env.example .env

#### 3. Install Composer
    composer install

#### 4. Autoload composer
    composer dump-autolad

#### 4. Install Application
    php artisan app:install
 {ROOT_PATH}/artisan schedule:run >> /dev/null 2>&1
