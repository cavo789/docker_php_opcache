# Docker - PHP/Apache - OpCache optimization

![Banner](./banner.svg)

The `~/src/bench.php` has been executed three times without OpCache and three times with OpCache in the Docker image. The script contains a `for...loop` to run all tests `100` times.

* Using PHP 7.4
    * Without OpCache
        * Run 1. Total time: 77.289
        * Run 2. Total time: 77.248
        * Run 3. Total time: 78.192
    * With OpCache
        * Run 1. Total time: 53.931 (30% of improvement versus run w/ #1)
        * Run 2. Total time: 54.238 (30% of improvement versus run w/ #2)
        * Run 3. Total time: 52.986 (32% of improvement versus run w/ #3)

* Using PHP 8.0.10
    * Without OpCache
        * Run 1. Total time: 75.324
        * Run 2. Total time: 76.235
        * Run 3. Total time: 75.537

    * With OpCache
        * Run 1. Total time: 53.506 (29% of improvement versus run w/ #1)
        * Run 2. Total time: 53.662 (30% of improvement versus run w/ #2)
        * Run 3. Total time: 53.727 (29% of improvement versus run w/ #3)

## Execution 

Run `./docker-down.sh ; ./docker-up.sh` to build the image then run

1. `docker exec -it myDockerApp_php php --version` to check if OpCache is well loaded,
2. `docker exec -it myDockerApp_php php bench.php` to run the benchmarking.

## Inspiration

Inspired by [https://github.com/prooph/docker-files/blob/master/php/config/opcache.ini](https://github.com/prooph/docker-files/blob/master/php/config/opcache.ini) and [https://www.hmazter.com/2019/04/speeding-up-php-docker-with-opcache/](https://www.hmazter.com/2019/04/speeding-up-php-docker-with-opcache/)

The `bench.php` script comes from [https://github.com/php/php-src/blob/master/Zend/bench.php](https://github.com/php/php-src/blob/master/Zend/bench.php)
