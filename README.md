# FITNESS TIME

[![Quality gate](https://sonarcloud.io/api/project_badges/quality_gate?project=dov118_fitness)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)

[![Build Status](https://github.com/dov118/fitness/workflows/CI/badge.svg)](https://github.com/dov118/fitness/actions/workflows/CI.yaml)
[![Bugs](https://sonarcloud.io/api/project_badges/measure?project=dov118_fitness&metric=bugs)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)
[![Code Smells](https://sonarcloud.io/api/project_badges/measure?project=dov118_fitness&metric=code_smells)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)
[![Vulnerabilities](https://sonarcloud.io/api/project_badges/measure?project=dov118_fitness&metric=vulnerabilities)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)
[![Security Rating](https://sonarcloud.io/api/project_badges/measure?project=dov118_fitness&metric=security_rating)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=dov118_fitness&metric=coverage)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)
[![Duplicated Lines (%)](https://sonarcloud.io/api/project_badges/measure?project=dov118_fitness&metric=duplicated_lines_density)](https://sonarcloud.io/summary/new_code?id=dov118_fitness)

------

In progress .....


### Install projet 
```bash
composer install
php artisan dusk:chrome-driver
npm install
```

### Init database
```bash
php artisan migrate:refresh --seed
```

### Run tests
```bash
php artisan test
php artisan dusk
```

### Create sqlite databases files
```bash
touch database/database.sqlite
touch database/testing.sqlite
```

### Setup .env
```bash
cat .env.example > .env
php artisan key:generate
```
in __DB_DATABASE__, put absolute path of __database.sqlite__ file (in __database__ folder)<br>
in __DISCORD_APPLICATION_ID__, put discord app id<br>
in __DISCORD_APPLICATION_KEY__, put discord app key<br>

### Setup .env.dusk.local
```bash
cat .env > .env.dusk.local
```
in __APP_ENV__, put __testing__<br>
in __DB_CONNECTION__, put __testing_sqlite__<br>
in __DB_DATABASE__, put absolute path of __testing.sqlite__ file (in __database__ folder)<br>
in __DISCORD_APPLICATION_ID__, put __DISCORD_APPLICATION_ID__<br>
in __DISCORD_APPLICATION_KEY__, empty value

### Setup .env.testing
```bash
cat .env > .env.testing
```

### Start local server
```bash
php artisan serve
npm run dev
```


