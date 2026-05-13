# sunnah.com Website

Frontend code for [sunnah.com](https://sunnah.com), built on the [Yii 2](https://www.yiiframework.com/) MVC framework (PHP).

## Table of Contents

- [Project Structure](#project-structure)
- [Quick Start with Docker](#quick-start-with-docker)
- [Manual Setup](#manual-setup)
- [Sample Database](#sample-database)
- [Contributing](#contributing)
- [License](#license)

## Project Structure

The repository is divided into two top-level areas:

- `public/` — the webroot. Contains `index.php`, static assets (`css/`, `js/`, `images/`), and the Yii bootstrap. Point your webserver at this directory.
- `application/` — the Yii application code (MVC), grouped into modules.

The Yii framework itself lives outside the repo; its location is hardcoded in `public/index.php`.

Inside `application/`, the key locations are:

| Path | Purpose |
|---|---|
| `config/main.php` | All configuration options: URL routes, database connection, components |
| `controllers/SController.php` | The base controller class that all feature controllers extend |
| `modules/front/controllers/` | Controllers for the public-facing site. The main controllers handle search, the index and sitewide pages, and the collection display (collections, books, individual ahadith) |
| `modules/front/models/` | Model classes — one per hadith language, plus `Book`, `Chapter`, `Collection`, `Narrator`, `Search` |
| `modules/front/views/` | View files, one subfolder per controller |
| `modules/front/views/layouts/` | Reusable view fragments: side menus, search box, widgets |
| `views/layouts/` | Sitewide view code: column layout, footer |

Yii groups MVC code into "modules", which you can think of as sections of the website (e.g. an admin section vs. a public section). The public-facing feature code lives under `modules/front/`.

## Quick Start with Docker

The recommended setup. Boots PHP + Apache + MySQL (with sample data) in one command.

1. Copy the environment file (**this step is required**):

   ```bash
   cp .env.local.sample .env.local
   ```

2. Start the stack:

   ```bash
   docker compose up --build
   ```

3. Visit [http://localhost](http://localhost) in your browser.

The source code is bind-mounted into the container, so edits are reflected without a rebuild. For development with VS Code, install the [Dev Containers](https://code.visualstudio.com/docs/devcontainers/containers) extension to attach to the running container.

## Manual Setup

If you'd rather run PHP and MySQL directly on your host:

1. Install PHP (see the `require.php` constraint in `composer.json`) and MySQL.
2. Install [Composer](https://getcomposer.org/download/) and run `composer install` from the repo root.
3. Import the sample database files from `db/` (see [Sample Database](#sample-database) below).
4. Point your webserver at the `public/` folder and add `index.php` as the default document.

### Windows with IIS

1. Create an IIS website pointing to the `public/` folder.
2. Add `index.php` as the default document and map the `.php` extension to the PHP handler.
3. Install [MySQL for Windows](https://dev.mysql.com/downloads/windows/) and import the sample database.
4. Visit `localhost` in a browser to verify the site is running.

## Sample Database

The `db/` directory contains SQL seed files. When using Docker, they are loaded automatically by the MySQL container via `docker-entrypoint-initdb.d`.

| File | Contents |
|---|---|
| `00-samplegitdb.sql` | Schema and base sample data |
| `01-hadithTable.sql` | Hadith records |
| `02-collections.sql` | Collection metadata |
| `03-bookdata.sql` | Book metadata |

When setting up manually, import the files in numerical order.

## Contributing

Bug reports, feature suggestions, and pull requests are welcome via [GitHub Issues](https://github.com/sunnah-com/website/issues) and [Pull Requests](https://github.com/sunnah-com/website/pulls).

When sending a pull request:

1. **One concern per PR.** Don't mix formatting changes with logic changes, and keep refactors separate from behavior changes.
2. **Reference the issue** being fixed in the commit message (for example, `Fixes #123`).
3. **Squash your commits** before merge, including any commits added in response to review feedback.
4. **Attach screenshots** for any UI changes.
5. **Discuss large changes first** by opening an issue before writing the code.

### Code Style

Format PHP code with [`php-cs-fixer`](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) before submitting. A [VS Code extension](https://marketplace.visualstudio.com/items?itemName=makao.phpcsfixer) is available.

### Content Corrections

If you've found an error in a hadith text, translation, grading, or reference, please **don't** open a code pull request against this repository — content corrections are handled through a separate workflow. Open an issue describing the correction and a maintainer will route it appropriately.

## License

BSD-3-Clause. See the `license` field in [`composer.json`](composer.json).
