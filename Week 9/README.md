# Week 9 – CodeIgniter 4 Projects

This folder contains two web application projects developed using **CodeIgniter 4** as part of the Pemrograman Berbasis Kerangka Kerja course.

## Projects

### 1. DIET TOMORROW – Online Bakery

An online bakery web application that allows customers to browse products, search for items, add products to their cart, and place orders. It also provides an admin dashboard for managing products and customer orders.

**Main Features:**
- Customer registration and login
- Product catalog, search, and category filtering
- Shopping cart and checkout
- Order history
- Admin dashboard and product management
- Order management

### 2. SIAKAD – Academic Information System

A web-based academic information system designed to manage academic activities and information within an educational institution.

**Main Features:**
- Role-based login for Admin, Lecturer, and Student
- Admin dashboard
- Student, lecturer, and course data management
- Course registration (KRS)
- Academic results (KHS) and transcript pages

## Technologies

- PHP
- CodeIgniter 4
- MySQL
- HTML, CSS, and JavaScript
- Bootstrap

## How to Run

Follow these steps for either project:

1. Clone or download this repository.
2. Open the desired project folder (`diet-tomorrow` or `siakad`) in the terminal.
3. Install dependencies:

   ```bash
   composer install
   ```

4. Copy the `env` file to `.env` and configure the database settings.
5. Create the corresponding MySQL database.
6. Run database migrations and seeders:

   ```bash
   php spark migrate
   php spark db:seed AdminSeeder
   ```

   For SIAKAD, use:

   ```bash
   php spark db:seed SiakadSeeder
   ```

   For DIET TOMORROW, run the available seeders as needed:

   ```bash
   php spark db:seed ProductSeeder
   ```

7. Start the development server:

   ```bash
   php spark serve
   ```

8. Open the application in your browser:

   - `http://localhost:8080`

**Note:** Make sure PHP, Composer, and MySQL are installed and running before starting the applications. Database configuration and available seeders may differ between projects.
