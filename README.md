# Syquence API :: math sequence generator

## A demo project showcasing basic API setup with Symfony.

- PHP 8.3
- Symfony 7.1

### Minimum requirements

Create a Symfony-App with a REST-API to fetch the sequence for different progressions:
-   Arithmetic
-   Geometric

Bonus
-   Fibonacci

The client states, for example, the start, increment or ratio, and the size of the sequence. 
Examples:

- Arithmetic: 1,2,3,4,5
   - *start*: 1
   - *increment*: 1
   - *size*: 5

- Geometric: 100,50,25,12.5,6.25
   - *start*: 100
   - *ratio*: 0.5
   - *size*: 5

- Fibonacci: 0,1,1,2,3,5,8,13,21,34
   - *size*: 10

The API returns the corresponding sequence as an array.

### What's inside

- [DDEV](https://ddev.com/) - my favorite docker-based local environment for all things PHP.
- Unit and feature tests with [PHPUnit](https://phpunit.de).
- Opinionated code formatting & linting with [PHP CS Fixer](https://cs.symfony.com/) & [PHPStan](https://phpstan.org/), orchestrated by lovely [GrumPHP](https://github.com/phpro/grumphp).
- API documentation powered by [Stoplight Elements](https://stoplight.io/open-source/elements).
- [JWT](https://jwt.io) authorization.

### Installation

1. Make sure you have [DDEV](https://ddev.readthedocs.io/en/latest/users/install/ddev-installation/) installed.
2. Clone, or download and extract the repository.
3. Change to the root of the project.
4. Run the following command:
   ```bash
   ddev start
   ```
   It will take some time to load and start all the containers, as well as install all the dependencies.

### Usage

1. Head over to the https://syquence.ddev.site in your browser and examine the API documentation.
2. You can send API requests directly from the documentation UI.
3. To generate the token, send the request to the *auth* endpoint **or** run the following command:
   ```bash
   ddev console syquence:token
   ```
4. Paste the obtained token (e.g. the output of the above-mentioned command) into the "Token" input in the documentation UI 
   before sending requests to endpoints requiring authorization.


### Useful commands

```bash
# Start containers (will also trigger the composer install)
ddev start

# If you make changes to the .ddev/config.yaml
ddev restart

# Open the application in the browser
ddev launch

# Lint the code
ddev lint

# Run all test suites
ddev test

# Run Symfony console command within the container
ddev console [command]

# Run Composer command within the container
ddev composer [command]

# Stop containers
ddev stop
```
