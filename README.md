# Click-journeY

The website of CyLanta, a travel agency based in Cergy, offers trips to the islands of French Polynesia.

**PREING-2 INFORMATIQUE IV PROJECT**.  
**Developed by MI-5 group A**.

## Contributors

- Romain MICHAUT-JOYEUX
- Nathan CHOUPIN
- Ziyad HADDADI

## Prerequisites

- A web browser that supports HTML5, CSS3 and JavaScript (Chrome, Firefox, ...).

## Installation

To clone the repository, use `git clone https://github.com/Zoulou95/Projet-Info4-CY-MI5A`.

## Languages used

- HTML5
- CSS3
- JavaScript

## Project structure

```
📦 Project folder
├── 📄 CyLanta_Graphic_Chart.pdf 
├── 📄 homepage.html
├── 📂 test
├── 📂 assets
│   ├── 🖼️ images
│   └── 🎬 video
├── 📂 src
│   ├── 📄 admin_panel.html
│   ├── 📄 advanced_search.html
│   ├── 📄 search.html
│   ├── 📄 userpage.html
│   ├── 📄 userpage_security.html
│   ├── 🎨 admin_panel_style.css
│   ├── 🎨 advanced_search_style.css
│   ├── 🎨 search_style.css
│   ├── 🎨 userpage_security_style.css
│   ├── 🎨 userpage_style.css
```

## Overview
 
- The page `homepage.html` is the default home page when you arrive on the website. It contains the website presentation and redirects to more specific search pages. It contains a registration form and an account creation form.

- `admin_panel.html` is used to manage user accounts. It presents a list of registered users and buttons to modify a property of each user (e.g. VIP customer, banning of the customer who would no longer be able to buy trips, etc.).

- `advanced_search.html` is a travel search page with several filter fields (dates, locations, options, price, etc.).

- `search.html` includes an integrated quick-search field for sorting trips by destination.

- `userpage.html` displays a logged-in user's own profile with buttons for modifying the various fields (name, email, etc.).

- `userpage_security.html` allows the user to modify his password.
**NOTE** : this page is temporary, we will integrate the security page into `userpage.html` when we get to phase 2 (JavaScript).