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

A web browser that supports HTML5, CSS3 and JavaScript (Chrome, Firefox, ...).

## Installation

To clone the repository, use the command `git clone https://github.com/Zoulou95/Projet-Info4-CY-MI5A` in your terminal.

## Utilisation

To explore the site, you can open `index.html`, which will redirect you to all the other pages.

## Project structure

```
├── 📂 assets
│   ├── 🖼️ images
│   └── 🎬 video
├── 📂 destinations
│   ├── 📄 presentation_bora.html
│   └── ....
├── 📂 src
│   ├── 📄 admin_panel.html
│   ├── 📄 ...
│   ├── 🎨 admin_panel_style.css
│   └── 🎨 ...
├── 📂 presentation_phase1
│   └── 🖼️ screenshots
├── 📄 CyLanta_Charte_Graphique.pdf
├── 🏠 index.html
├── 📄 Rapport_Projet_Info_P2MI5-A.pdf
```

## Overview

- `base_style.css` is the default style sheet for all other pages: it defines their structure and the style of the navigation bar and footers.

- `presentation_style.css` is the default style sheet for all presentation pages located in `/destination`.
 
- The page `index.html` is the default home page when you arrive on the website. It contains the website presentation and redirects to more specific search pages. It contains a registration form and an account creation form.

- `admin_panel.html` is used to manage user accounts. It presents a list of registered users and buttons to modify a property of each user (e.g. VIP customer, banning of the customer who would no longer be able to buy trips, etc.).

- `advanced_search.html` is a travel search page with several filter fields (dates, locations, options, price, etc.).

- `search.html` includes an integrated quick-search field for sorting trips by destination.

- `userpage.html` displays a logged-in user's own profile with buttons for modifying the various fields (name, email, etc.).

- `userpage_security.html` allows the user to modify his password.
**NOTE** : this page is temporary, we will integrate the security page into `userpage.html` when we get to phase 2 (JavaScript).

- The presentations pages in the `/destinations` folder are used to display and present the various holidays available and their characteristics (price, user ratings, etc.).
