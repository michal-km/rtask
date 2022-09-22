#Exercise for REST services

The module source code is located in **exercise** folder.

##Prerequisites

- docker
- docker-compose (on linux systems needs to be installed separately)
 - Available ports 80 and 3306. If a web stack is already installed and causing port conflicts, these values can be changed in docker-compose.yml (f.e. to 8080 and 3307) and docker/php/settings.php near the end of file.

##Setting up the environment

1. Get the source
```
git clone https://github.com/michal-km/rtask
cd rtask
```

2. Build
```
docker build
docker-compose up -d
```

The build process can take up to several minutes. When all containers will be up and running, Drupal site should be present at http://localhost

3. Enable module

```
docker exec -it -w /var/www/rtask {container_id} drush en exercise -y
```

4. Populate with example data

TBD

##In scope

TBD

##Out of scope

- Hardening Debian security
- SSL/HTTPS
- API settings
- Full CRUD with authentication