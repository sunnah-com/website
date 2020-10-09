# sunnah-website
This is the front end code for sunnah.com . It is built atop the Yii MVC framework.

The top level structure is divided into application code (application folder) that includes MVC code and the public folder which contains index.php, css, js, etc. 

Your webserver should point to the public folder. The Yii framework code needs to reside on the machine as well; its location is hardcoded into public/index.php .

Under the applications folder, here are the important locations:

* config/main.php : All the configuration options, including URL routes, database connections, etc.
* Yii divides its MVC stuff into "modules" that share code. Think of them as sections of a website. For example, an admin section vs. a public section. 
* modules/default/controllers: All controller classes. There are three main controllers: the search page, the index and sitewide pages, and the collection controller which includes actions for displaying collections, books, and ahadith.
* modules/default/models: All model classes. Each kind of object has a model class. E.g. hadith, book, collection.
* modules/default/views: Each controller has actions which have view code. This folder contains the view code.
* modules/default/views/layouts: Other view code corresponding to side menus, search box, widgets, etc.
* modules/views: Sitewide view code like column layout, footer.
* modules/views/site: Not used. This folder is for view code that needs to be the same across modules.

## Running on windows

* Install PHP 7.3
* Create an iis website and point it to the public folder
* Add the index.php file as default document
* Add handler mapping for .php files in iis
* [Download](https://dev.mysql.com/downloads/windows/) and install mysql for windows
* Import the sample db in mysql
* [Download](https://getcomposer.org/download/) and install composer
* Run `install` comand of composer in the root dir
* Visit the localhost url to see the site running   


## Launching the Dev Container

Launching the dev container is composed of a simple `docker-compose` command:

Run the following command in the same directory as the Dockerfile:

`docker-compose up --build`

You should then be able to access the webserver using port 80 on the container's host.

Use [Visual Studio Code](https://code.visualstudio.com/) with [Remote Containers](https://code.visualstudio.com/docs/remote/containers) extensions to attach to running instance and try out changes rapidly.

Use the [php cs fixer](https://marketplace.visualstudio.com/items?itemName=makao.phpcsfixer) extension for formatting code.
