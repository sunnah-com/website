<!--
*** Thank you for checking out this Sunnah.com repository.
*** If you have suggestions to improve this project, please fork the repo
*** and open a pull request or create an issue.
*** May Allah put barakah in every sincere contribution.
-->

<!-- PROJECT LOGO -->
<br />
<p align="center">
  <a href="https://sunnah.com">
    <img src="public/images/fb_logo.png" alt="Logo" width="80" height="80">
  </a>

  <h1 align="center">Sunnah.com</h1>

  <p align="center">
    The official frontend source code repository for Sunnah.com
    <br />
    <br />
    <a href="https://sunnah.com">Visit Sunnah.com</a>
   . 
    <a href="https://github.com/sunnah-com/website/issues">Report Bug</a>
 	 ·
	  <a href="https://github.com/sunnah-com/website/issues">Request Feature</a>
  </p>
</p>
<!-- PROJECT SHIELDS -->

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Issues][issues-shield]][issues-url]
[![Stargazers][stars-shield]][stars-url]
[![License][license-shield]][license-url]

This repository contains the frontend application code for **Sunnah.com**.  
The project is built atop the Yii 2 MVC framework and serves as the primary web interface for browsing hadith collections, books, and individual narrations.

---

## Project Structure Overview

The top level structure is divided into two major parts:

- **application/**  
  Contains all MVC related application code.

- **public/**  
  Contains the web root, including `index.php`, CSS, JavaScript, and other publicly accessible assets.

Your web server **must point to the `public/` directory**.

The Yii framework source code must also exist on the machine. Its path is hardcoded inside `public/index.php`.

---

## Application Directory Structure

Inside the `application/` folder, the following locations are most important:

### Configuration
- `config/main.php`  
  Contains application configuration such as URL routing, database connections, and environment settings.

### MVC Modules
Yii divides the application into **modules**, which represent logical sections of the website.

#### Controllers
- `modules/front/controllers`  
  Contains all controller classes. The main controllers include:
  - Search related pages
  - Index and sitewide pages
  - Collection controller responsible for collections, books, and ahadith

#### Models
- `modules/front/models`  
  Contains model classes representing core entities such as:
  - Hadith
  - Book
  - Collection

#### Views
- `modules/front/views`  
  View files corresponding to controller actions.

- `modules/front/views/layouts`  
  Shared UI components such as side menus, widgets, and the search box.

- `views/layouts`  
  Sitewide layouts including headers, footers, and column structures.

---

## Running the App Locally (Windows)

### Requirements
- PHP 7.3
- MySQL
- Composer
- IIS Web Server

### Setup Steps
1. Install PHP 7.3
2. Create an IIS website and point it to the `public/` directory
3. Add `index.php` as the default document
4. Add handler mappings for `.php` files in IIS
5. Install [MySQL for Windows](https://dev.mysql.com/downloads/windows/)
6. Import the provided sample database into MySQL
7. Install [Composer](https://getcomposer.org/download/)
8. Run the Composer install command in the project root directory
9. Visit `http://localhost` in your browser

If configured correctly, the site should load successfully.

---

## Working With the Dev Container

If you prefer not to configure a full local environment, a Docker based development container is available.

### Steps
1. Copy `.env.local.sample` to `.env.local`
2. Run the following command in the directory containing the `Dockerfile`:

```bash
docker-compose up --build
```
3. Access the web server on port `80` of the container host

### Development Workflow
- The source code is mounted as a volume inside the container
- Any file changeiately without rebuilding
- Use [Visual Studio Code](https://code.visualstudio.com/) with the  [Remote Containers](https://code.visualstudio.com/docs/remote/containers) extension to attach to the running instance

---

## Code Style and Formatting
- Use [php cs fixer](https://marketplace.visualstudio.com/items?itemName=makao.phpcsfixer) for consistent code formatting
- Follow existing project conventions when adding or modifying code

---

## How to Contribute
Contributions are welcome from anyone with sincere intentions to improve access to authentic hadith.

Please do not copy or reuse this project for derivative platforms. This project exists solely to serve the Ummah and preserve knowledge with integrity.

If you wish to help:
- Check existing issues
- Open a new issue for bugs or suggestions
- Submit a pull request with a clear explanation

---

## Filing Bugs
If you encounter a bug, please open an issue on GitHub with:
- Clear reproduction steps
- Expected vs actual behavior
- Screenshots if applicable

---

## License
This project is licensed under the terms specified in the repository license file.

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->

[contributors-shield]: https://img.shields.io/github/contributors/sunnah-com/website?style=for-the-badge
[contributors-url]: https://github.com/sunnah-com/website/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/sunnah-com/website?style=for-the-badge
[forks-url]: https://github.com/sunnah-com/website/network/members
[stars-shield]: https://img.shields.io/github/stars/sunnah-com/website?style=for-the-badge
[stars-url]: https://github.com/sunnah-com/website/stargazers
[issues-shield]: https://img.shields.io/github/issues/sunnah-com/website?style=for-the-badge
[issues-url]: https://github.com/sunnah-com/website/issues
[license-shield]: https://img.shields.io/github/license/sunnah-com/website?style=for-the-badge
[license-url]: https://github.com/sunnah-com/website/blob/master/LICENSE
