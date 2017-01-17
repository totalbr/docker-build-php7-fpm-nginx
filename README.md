
Ubuntu, php7-fpm and Nginx
================================

Configure your dns in file `resolv.conf` before build, default is:

    nameserver 8.8.8.8

------------------

Xdebug is disabled by default, by questions of performance when executing `composer`, for enable xdebug only execute
one alias created on build, `php_xdebug` ,for example when execute your tests with `phpunit`, because is necessary for 
to generate your tests coverage.

    php_xdebug vendor/bin/phpunit

------------------


**Execute the file `init.sh` for up the docker containers**

```bash

https://github.com/totalbr/docker-build-php7-fpm-nginx for the canonical source repository 
Environment Ubuntu, php7-fpm and nginx, container for execution diffs e-cidade

 
 _____ ___ _____  _    _     ____  ____  
|_   _/ _ \_   _|/ \  | |   | __ )|  _ \ 
  | || | | || | / _ \ | |   |  _ \| |_) |
  | || |_| || |/ ___ \| |___| |_) |  _ < 
  |_| \___/ |_/_/   \_\_____|____/|_| \_\
                                         
 
DOCKER
Generate new containers ? [ 1 ] 
Delete all containers ?   [ 2 ] 
Start new build ?         [ 3 ]

```

__Access a shell:__
```
docker exec -it php7 bash
```

-------


#### CHANGELOG

[Link](https://github.com/totalbr/docker-build-php7-fpm-nginx/blob/master/CHANGELOG.md)
