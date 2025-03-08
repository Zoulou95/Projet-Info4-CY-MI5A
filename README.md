# Click-journeY

The website of CyLanta, a travel agency based in Cergy.

**PREING-2 INFORMATIQUE IV PROJECT**.  
**Developed by MI-5 group A**.

## Contributors

- Romain MICHAUT-JOYEUX
- Nathan CHOUPIN
- Ziyad HADDADI

## About CyLanta

Our website is a travel agency website that allows you to book and pay for pseudo-made holidays to various destinations. Our travel agency is called “CyLanta” and is located in Cergy, France. We propose to book stays on the islands of French Polynesia (Bora-Bora, Tahiti, etc.). The customer can choose from several tours without being able to modify the steps, but can modify the options (restaurants, hotels, the number of people).

## Languages used

![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)  ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)   ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)   ![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)   ![JSON](https://img.shields.io/badge/JSON-000000?style=for-the-badge&logo=json&logoColor=white)  

## Prerequisites

- A web browser that supports HTML5, CSS3 and JavaScript (Chrome, Firefox, ...).
- PHP and a local server are required to run the project locally.

## Installation

To clone the repository, use the command `git clone https://github.com/Zoulou95/Projet-Info4-CY-MI5A` in your terminal.

## Utilisation

To explore the site, you need to open a local server on your machine.

### On Debian (or similar Linux distributions):
1. Ensure PHP is installed. You can install PHP by running: `sudo apt install php`

2. Navigate to the project folder in the terminal.

3. Start the PHP built-in server with the command: `php -S localhost:8000`

4. Open your web browser and go to http://localhost:8000 to view the project.

### On Windows:
1. Install PHP from the official website: https://www.php.net/downloads.php

2. Navigate to the project folder in the terminal.

3. Start the PHP built-in server with the command: `php -S localhost:8000`

4. Open your web browser and go to http://localhost:8000 to view the project.

### On macOS:
1. Install PHP via Homebrew, use `brew install php`.

2. Navigate to the project folder in the terminal.

3. Start the PHP built-in server with the command: `php -S localhost:8000`

4. Open your web browser and go to http://localhost:8000 to view the project.

## Project structure

```
📦 CyLanta Project
├── 📂 assets
│   ├── 🖼️ images
│   └── 🎬 video
├── 📂 data
│   ├── 🖼️ images
│   └── 🎬 video
├── 📂 scripts
│   ├── 📊 trip_data.json
│   └── 📊 ...
├── 📂 src
│   ├── 📄 admin_panel.php
│   ├── 📄 trip.php
│   ├── 📄 ...
│   ├── 🎨 admin_panel_style.css
│   ├── 🎨 trip.css
│   └── 🎨 ...
├── 📂 presentation_phase1
│   └── 🖼️ screenshots
├── 📄 CyLanta_Charte_Graphique.pdf
├── 🏠 index.html
├── 📄 Rapport_Projet_Info_P2MI5-A.pdf
```

## Page overview

- `base_style.css` is the default style sheet for all other pages: it defines their structure and the style of the navigation bar and footers.

- `trip_style.css` is the default style sheet for all trips presentation pages.
 
- The page `index.php` is the default home page when you arrive on the website. It contains the website presentation and redirects to more specific search pages. It contains a registration form and an account creation form.

- `admin_panel.php` is used to manage user accounts. It presents a list of registered users and buttons to modify a property of each user (e.g. VIP customer, banning of the customer who would no longer be able to buy trips, etc.).

- `advanced_search.php` is a travel search page with several filter fields (dates, locations, options, price, etc.).

- `search.php` includes an integrated quick-search field for sorting trips by destination.

- `trip.php` is the display page for trips and their characteristics. This page allows users to plan their trip and modify each stage to select activities and hotels. The display of this page depends on the id of the trip to be displayed, present in the `trip_data.json` file.

- `userpage.php` displays a logged-in user's own profile with buttons for modifying the various fields (name, email, etc.).

- `userpage_security.php` allows the user to modify his password.
**NOTE** : this page is temporary, we will integrate the security page into `userpage.html` when we get to phase 3 (JavaScript).
