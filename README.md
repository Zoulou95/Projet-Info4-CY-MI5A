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

- A web browser that supports HTML5, CSS3 and JavaScript (Chrome, Firefox, Edge, etc.).
- PHP and a local server are required to run the project locally.

## Installation

To clone the repository, use the command `git clone https://github.com/Zoulou95/Projet-Info4-CY-MI5A` in your terminal.

## Utilisation

To explore the site, you need to open a local server on your machine.

### On Debian (or similar Linux distributions):
1. Ensure PHP is installed. You can install PHP by running: `sudo apt update` and `sudo apt install php`

2. Navigate in the project folder in the terminal (same directory as `index.php`).

3. Start the PHP built-in server with the command: `php -S localhost:8000`

4. Open your web browser and go to http://localhost:8000 to view the project.

### On Windows:
1. Install PHP from the official website: https://www.php.net/downloads.php

2. Navigate in the project folder in the terminal (same directory as `index.php`).

3. Start the PHP built-in server with the command: `php -S localhost:8000`

4. Open your web browser and go to http://localhost:8000 to view the project.

### On macOS:
1. Install PHP via Homebrew, use `brew install php`.

2. Navigate in the project folder in the terminal (same directory as `index.php`).

3. Start the PHP built-in server with the command: `php -S localhost:8000`

4. Open your web browser and go to http://localhost:8000 to view the project.

## Usage

We've created a file named `user_list.txt` in the `/data` folder for easy access to information (passwords are hashed in our database). You'll be able to retrieve user information and run tests according to their roles (standard, vip, admin, banned).
Futhermore, you can find a dummy bank card in `/data/card.txt` for purchases.

**Please note**: this is not a database.

## Project structure

```
📦 CyLanta Project
├── 📂 assets
│   ├── 🖼️ images
│   └── 🎬 video
├── 📂 css
│   ├── 🎨 admin_panel_style.css
│   └── 🎨 ...
├── 📂 data
│   ├── 📊 trip_data.json
│   └── 📊 ...
├── 📂 includes
│   ├── 📄 header.php
│   └── 📄 ...
├── 📂 presentation_phase_3
├── 📂 script
│   ├── 📄 timelineBrowse.js
│   └── 📄 registration.js
├── 📂 src
│   ├── 📄 admin_panel.php
│   ├── 📄 trip.php
│   └── 📄 ...
├── 📄 CyLanta_Charte_Graphique.pdf
├── 🏠 index.php
├── 📄 Rapport_Projet_Info_P2MI5-A.pdf
```

## File overview

## `/data` files

`cart_history_data.json` is used to retrieve users' shopping cart histories.

`user_data.json` contains information on all users (name, email, hashed password, ID, etc.).

`trip_data.json` contains information on all trips (name, ID, price, tags, etc.).

`purchase_data.json` contains information on all purchases (ID, payment status, buyer, etc.).


## `/includes` files

The pages in the `/includes` folder contain the PHP functions used by all the code for page display and data processing.

- `error.php` displays an error in the server console and to the user in the event of an error.

- `header.php` and `footer.php` display the navigation bar and footer on all pages.

- `logs.php` allows administrators to track website activity in the `server.log` file (login, registration, etc.).

- `profile_manager.php` is the page used to retrieve profile information from our json database, and update it if necessary.

- `trip_function.php` is the page for displaying and configuring trips.

- `trip_function.php` is the page for displaying and configuring trips.

- The functions in `session_start.php` are used to check the existence of cookies or to create them, and to initialize session variables.

## `/src` files
 
- `admin_panel.php` is used to manage user accounts. It presents a list of registered users and buttons to modify a property of each user (e.g. VIP customer, banning of the customer who would no longer be able to buy trips, etc.).

- `cart.php` allows you to place several trips in a shopping cart and then purchase them together.

- `confirmation.php` and `order_confirmed.php` pages respectively summarize a user's choice of a trip and display a message to indicate that the purchase was successful.

- `inscription.php` and `connexion.php` pages contain functions for managing user data and allowing a user to log in.

- `purchase_details.php` provides order information for a trip purchased by a user

- `result.php` provides the user with the results of a quick trip search or a more specific search. This page takes you back to the search page if no trip is found.

- `search.php` and `advanced_search.php` includes an integrated quick-search and specific field for sorting trips by a specific tag (e.g soleil, plongée, etc.) or a price, a date.

- `trip.php` is the display page for trips and their characteristics. This page allows users to plan their trip and modify each stage to select activities and hotels. The display of this page depends on the id of the trip to be displayed.

- `userpage.php` displays a logged-in user's own profile with buttons for modifying the various fields (name, order history, password, etc.).

---

- `index.php` is the default home page when you arrive on the website and contains the website presentation. It contains a registration form and an account creation form.
