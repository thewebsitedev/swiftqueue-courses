# Swiftqueue Courses API

This is a repository for the Swiftqueue Courses API made entirely in vanilla PHP. It is a RESTful API that allows you to create, read, update and delete courses. It also allows you to register and login users.

### Requirements

To run the API, you need to have the following technologies installed:
* [PHP](https://www.php.net/) [v8.2.0]
* [MySQL](https://www.mysql.com/) [v5.7.39]
* [Composer](https://getcomposer.org/) [latest]

Or you can use [MAMP](https://www.mamp.info/en/) or [XAMPP](https://www.apachefriends.org/index.html) to install all of the above.

### Installation

To install the courses, you need to have [Git](https://git-scm.com/) installed. Then, run the following command in your terminal:

```bash
git clone https://github.com/thewebsitedev/swiftqueue-courses.git
```

You need to have some sort of server environment to run the courses. You can use [MAMP](https://www.mamp.info/en/) or [XAMPP](https://www.apachefriends.org/index.html) for this. If you are using MAMP, you need to put the courses in the `htdocs` folder. If you are using XAMPP, you need to put the courses in the `htdocs` folder.

Make sure you have [Composer](https://getcomposer.org/) installed. Then, run the following command in your terminal:

```bash
composer require vlucas/phpdotenv
```

Then, run the following command in your terminal:

```bash
composer dump-autoload
```

Also make sure to update the environment variables in the `.env` file according to your setup.

### Usage

To use the courses api, you need to have a browser installed. You can use [Google Chrome](https://www.google.com/chrome/) or [Mozilla Firefox](https://www.mozilla.org/en-US/firefox/new/). Then, open the browser and go to [http://localhost:8888/swiftqueue-test/api/courses/](http://localhost:8888/swiftqueue-test/api/courses/). You should see a list of the courses. Click on the course you want to view and you will be taken to the course page.

### API

List of API urls:
| API URLs  | Available Methods  |
|---|---|
| [http://localhost:8888/swiftqueue-test/api/courses/](http://localhost:8888/swiftqueue-test/api/courses/index.php)  | GET, POST, PUT, DELETE  |
|  [http://localhost:8888/swiftqueue-test/api/users/](http://localhost:8888/swiftqueue-test/api/users/index.php) | POST  |
|   |   |

Getting a list of courses:
```bash
curl http://localhost:8888/swiftqueue-test/api/courses/
```

Getting a single course:
```bash
curl http://localhost:8888/swiftqueue-test/api/courses/index.php?id=1
```

Creating a course:
```bash
curl -X POST -H "Content-Type: application/json" -d '{"name":"Test Course","start_date":"2024-01-01T00:00","end_date":"2024-01-01T00:00",status:"active"}' http://localhost:8888/swiftqueue-test/api/courses/index.php
```

Deleting a course:
```bash
curl -X DELETE http://localhost:8888/swiftqueue-test/api/courses/index.php?id=1
```

Updating a course:
```bash
curl -X PUT -H "Content-Type: application/json" -d '{"id":1,"name":"Test Course","start_date":"2024-01-01T00:00","end_date":"2024-01-01T00:00",status:"active"}' http://localhost:8888/swiftqueue-test/api/courses/index.php
```

User login:
```bash
curl -X POST -H "Content-Type: application/json" -d '{"login":true,"email":"xyz@abc.com","password":"123456"}' http://localhost:8888/swiftqueue-test/api/users/index.php
```

User registration:
```bash
curl -X POST -H "Content-Type: application/json" -d '{"register":true,"email":"","password":"","first_name":"","last_name":"","role":""}' http://localhost:8888/swiftqueue-test/api/users/index.php
```

### Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

### License

[GPLv3](https://choosealicense.com/licenses/gpl-3.0/)