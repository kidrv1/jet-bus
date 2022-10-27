# Bus Project

## Requirements

-   Composer
-   Xampp/Wamp/Mysql

## Installation

1. Go to the folder where you want to save the project and type the following in the terminal

    ```
     git clone https://github.com/kidrv1/jet-bus.git
    ```

2. Open the folder and create a copy the `.env.example` and rename it to `.env`
3. Open the `.env` and change the following
    ```
     DB_DATABASE=yourdbname
     DB_USERNAME=root
     DB_PASSWORD=
    ```
4. Start your MySQL server
5. Open the terminal inside the project folder and run the following
    ```
     composer install
     php artisan key:generate
     php artisan migrate:fresh --seed
    ```
6. To start the local server type
    ```
     php artisan serve
    ```
7. Go to `127.0.0.1:8000` to view the server
