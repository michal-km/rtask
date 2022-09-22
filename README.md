# Exercise in REST services

The module source code is located in **exercise** folder.
All docker related files are located in **docker** folder.

## Prerequisites

- docker
- docker-compose (on linux systems needs to be installed separately)
 - Available ports 80 and 3306. If a web stack is already installed and causing port conflicts, these values can be changed in docker-compose.yml (f.e. to 8080 and 3307) and docker/php/settings.php near the end of file.

## Setting up the environment

### 1. Get the source
```
git clone https://github.com/michal-km/rtask
cd rtask
```

### 2. Build & run
```
docker-compose up -d
```

The build process can take up to several minutes.

### 3. Populate with example data

Five example article nodes are available out of the box for purpose of testing. More can be added in the CMS which can be accessed at http://localhost/user/login with credentials: admin / zaTtYzpCvxVvwQj

### 4. Use

When all containers will be up and running, Drupal site should be present at http://localhost, installed with minimal configuration. All neccessary modules, services and resources should be already installed and enabled. The endpoint should be available at http://localhost/article/all.

If the endpoint returns error 500 (unable to find service exercise.rest), a cache rebuild is needed. To perform that, please login to CMS and clear cache manually or execute a command:

```
docker exec -it -w /var/www/rtask {container_id} drush cache:rebuild
```

## In scope

- To define an article content type with fields: title, description, image (cropped),
- To create bundle class for the article content type,
- To provide a single endpoint returning all articles in JSON response.

## Out of scope, but needed in real life case

- Hardening Debian security
- Using composer as regular user
- SSL/HTTPS
- Authentication
- Settings forms
