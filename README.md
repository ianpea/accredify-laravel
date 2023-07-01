# About
This application is built as a result of the assignment by Accredify Team - [Technical Assessment for Laravel Developer](https://accredify.notion.site/Technical-Assessment-for-Laravel-Developer-de808af21ca249ba8f4b2d8f1aaf2a66). It is built using the official Laravel docker image(s) which includes Laravel, MySQL and redis.

Includes:
- Register, login and logout using Laravel authentication.
- Verify a valid JSON document.
- Log results into database.
- Utility class to return paths of each JSON value.
- Test cases that covers 90% of the features provided.

## How To Deploy Locally (macOS)
1. Install docker and unzip project files.
2. Navigate into project folder, then run below command to start the docker containers
> ``` ./vendor/bin/sail up ```
3. Verify in Docker desktop that there are 4 containers running under <em>"accredify-laravel"</em>, i.e. <b>
- *laravel.app-1, 
- *mysql-1 and
- *redis-1.
- *phpmyadmin-1</b>
4. Now that the containers are up, you can run your app locally in the app folder using terminal <em><strong>(Do not close the previous terminal, they keep docker containers running.)</strong></em>, the below code will give you a localhost link that you can use to run the next step.
> ``` npm run dev ```
5. To view and test the app, navigate to the link below (you may refer to 4.)
> ``` http://localhost ``` 
6. To verify the test cases, run this command in a separate terminal in app folder 
> ``` php artisan test ```
7. To verify the data, navigate to 
> ``` http://localhost:80 ```

## How To Deploy Locally (Windows)
1. TBC

## Author
Prepared by, Ian Pee, 2023-07-02
