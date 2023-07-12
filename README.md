# About
This application is built as a result of the assignment by Accredify Team - [Technical Assessment for Laravel Developer]. It is built using the official Laravel docker image(s) which includes Laravel, MySQL and redis.

## Live Website - [Click Here](http://verification.portal.ianpee.com) ##

Feature includes:
- Register, login and logout using Laravel authentication.
- Verify a valid JSON document.
- Log results into database.
- Utility class to return paths of each JSON value.
- Test cases that covers 90% of the features provided.

Project Files includes:
README.MD, ROADMAP.MD & 'Accredify Laravel Diagrams.pdf'.

## How To Deploy Locally (macOS)
1. Install docker, composer and unzip project files into a folder.
2. Navigate into the folder created
3. ## In the folder, run below in sequence (may take sometime) ##
    - run the command
        > ``` composer install ```

        ![Alt text](<SS 2023-07-12 at 12.46.38.png>)
    - duplicate a new file in root of folder called '.env' from '.env.example' without quotes, then
        > ``` Add a new field under APP_URL called APP_PORT=9001 ```
    - prepare MySQL connection
        > ``` update the following fields with 'DB_' prefix to point to the MySQL container. ```

        ![Alt text](<SS 2023-07-12 at 12.48.24.png>)
    - run below command to install node modules (>node v18)
        > ``` npm install ```

    - run below 2 commands to start the docker containers (First time running will take a while to install docker images)
        > ``` ./vendor/bin/sail up ```

    - prepare the database
        > ``` php artisan migrate ```

    - generate app key
        > ``` php artisan key:gen ```

    - refresh app cache
        > ``` php artisan optimize:clear ```\
        > ``` php artisan optimize ```

4. Verify in Docker desktop that there are 4 containers running under <em>"accredify-laravel"</em>, i.e. <b>
- *laravel.app-1, 
- *mysql-1 and
- *redis-1.
- *phpmyadmin-1</b>
5. Now that the containers are up, you can run your app locally in the app folder using command below in new terminal
    > ``` npm run dev ```
6. To view and test the app, navigate to the link below (you may refer to APP_URL variable in .env file)
    The link is a combination of APP_URL + APP_PORT
    > ``` http://localhost:9001 ``` 
7. To verify the test cases, run this command in a separate terminal in app folder 
    > ``` php artisan test ```

    Results:

    ![Alt text](<SS 2023-07-12 at 14.37.49.png>)


## Author
Prepared by, Ian Pee, 2023-07-02
