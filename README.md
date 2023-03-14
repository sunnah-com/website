# sunnah-website
This is the front end code for [sunnah.com](https://sunnah.com). It is built atop the Yii 2 MVC framework.

The top level structure is divided into application code (in the `application` folder) that includes MVC code and the `public` folder which contains `index.php`, `css`, `js`, and others. 

Your webserver should point to the public folder. The Yii framework code needs to reside on the machine as well; its location is hardcoded into `public/index.php`.

Under the `application` folder, here are the important locations:

* `config/main.php`: All the configuration options, including URL routes, database connections, etc.
* Yii divides its MVC code into "modules" that share code. Think of them as sections of a website. For example, an admin section vs. a public section. 
* `modules/front/controllers`: All controller classes. There are three main controllers: the search page, the index and sitewide pages, and the collection controller which includes actions for displaying collections, books, and ahadith.
* `modules/front/models`: All model classes. Each kind of object has a model class. E.g. hadith, book, collection.
* `modules/front/views`: Each controller has actions which have view code. This folder contains the view code.
* `modules/front/views/layouts`: Other view code corresponding to side menus, search box, widgets, etc.
* `views/layouts`: Sitewide view code like column layout, footer.


## Running on Windows

* Install PHP 7.3
* Create an IIS website and point it to the `public` folder
* Add the `index.php` file as default document
* Add handler mapping for `.php` files in iis
* Download and install [MySQL for Windows](https://dev.mysql.com/downloads/windows/)
* Import the sample db in MySQL
* Download and install [Composer](https://getcomposer.org/download/)
* Run the `install` comand of composer in the root dir
* Visit localhost in a browser to see the site running   


## Working with the Dev Container
If you don't want to set up a complete dev environment on your host, you can use a Docker container to host the PHP environment, dependencies, and web server. The source code is mounted as a volume inside the container, so any changes will reflect immediately inside the container without having to rebuild it.

Launching the dev container is composed of a simple `docker-compose` command. First however, copy the `.env.local.sample` file to `.env.local` (**important**). Then run the following command in the same directory as the Dockerfile:

`docker-compose up --build`

You should then be able to access the webserver using port 80 on the container's host.

Use [Visual Studio Code](https://code.visualstudio.com/) with [Remote Containers](https://code.visualstudio.com/docs/remote/containers) extensions to attach to running instance and try out changes rapidly.

Use the [php cs fixer](https://marketplace.visualstudio.com/items?itemName=makao.phpcsfixer) extension for formatting code.
