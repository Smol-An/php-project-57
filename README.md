### Hexlet tests and linter status:
[![Actions Status](https://github.com/Smol-An/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Smol-An/php-project-57/actions)
[![PHP CI](https://github.com/Smol-An/php-project-57/actions/workflows/phpci.yml/badge.svg)](https://github.com/Smol-An/php-project-57/actions/workflows/phpci.yml)
[![Maintainability](https://api.codeclimate.com/v1/badges/92a6ae456edcb44d8828/maintainability)](https://codeclimate.com/github/Smol-An/php-project-57/maintainability)

### About the project
Task Manager is a task management system that allows you to set tasks, assign executors and change their statuses.


### Requirements
* PHP >= 8.1
* Composer >= 2.5.5
* PostgreSQL >= 16.1
* GNU Make >= 4.3

### Setup
```
$ git clone https://github.com/Smol-An/php-project-57.git
$ cd php-project-57
$ make setup
```

### Run
Use environment variables to connect to the database.

```
$ php artisan migrate:fresh --seed
$ make start
```

Open http://localhost:8000/ in your browser.

### Usage
Open in browser: https://task-manager-mp6j.onrender.com
