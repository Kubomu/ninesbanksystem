# Nines Bank System  

For Study Purposes Only!  

Welcome to **Nines Bank System**, a comprehensive banking management solution designed for administrators, tellers, and loan officers. This system supports multiple roles and features to manage customer accounts, transactions, loans, and payments efficiently.  

## Table of Contents  

- [Features](#features)  
- [Technologies](#technologies)  
- [Installation](#installation)  
- [Usage](#usage)  
- [Screenshots](#screenshots)  

## Features  

- **Admin Dashboard**: Manage admins, customers, accounts, transactions, loans, and payments.  
- **Teller Dashboard**: Manage customers, accounts, and transactions with restricted permissions.  
- **Loan Officer Dashboard**: Manage loans and payments with dedicated access.  
- **Secure Authentication**: Role-based access control (RBAC) for different user roles.  
- **Customer Management**: Add and view customers.  
- **Account Management**: Add and view accounts.  
- **Transactions**: Handle transfers, withdrawals, and view balances (Note: deposit functionality added but currently non-functional due to study scope constraints).  
- **Loan Management**: Apply for and view loans.  
- **Payment System**: Add and view payments.  
- **Session Tracking**: Monitor active sessions and counters for each user.  
- **CSRF Protection**: Ensures secure transactions.  

## Technologies  

- **PHP**: Backend logic for role-based access, transaction handling, and more.  
- **MySQL**: Database used for storing customer, account, transaction, and loan information.  
- **HTML, CSS, JavaScript**: Frontend user interface.  
- **Bootstrap & Tailwind CSS**: Responsive design and modern UI/UX components.  
- **Font Awesome**: Icons for better visual representation.  
- **Git**: Version control for managing project updates.  
- **GitHub**: Collaborative development and hosting.  

## Installation  

1. Clone this repository:  
   ```bash  
   git clone https://github.com/Kubomu/ninesbanksystem.git  

2. Navigate to the project directory:
   ```bash
   cd ninesbanksystem
2. Ensure you have a WAMP/LAMP/XAMPP server installed with MySQL and PHP configured.
3. Import the database: Open your server's phpMyAdmin and import the provided bank_system.sql file.
4. Start your local server and access the project via your browser (e.g., http://localhost/bank_system).

 ## Usage
 
- **Admin**: Manage the entire banking system, including users, transactions, and loans.
- **Teller**: Manage customer and account creation, along with basic transactions.
- **Loan Officer**: Handle loan applications and payments.
- **Logging In**: You can log in with different roles (Admin, Teller, Loan Officer) to access different features.

## Screenshots

1. **Login Page**
   ![Login Page](Screenshots/login_page.png)

2. **Admin Dashboard**
   ![Admin Dashboard](Screenshots/admin_dashboard.png)

3. **Teller Dashboard**
   ![Teller Dashboard](Screenshots/teller_dashboard.png)

4. **Loan Officer Dashboard**
   ![Loan Officer Dashboard](Screenshots/loan_officer_dashboard.png)

5. **Transaction Management**
   ![Transaction Management](Screenshots/transaction_management.png)

6. **Error Page (Deposit Feature)**
   ![Error Page](Screenshots/error_page_deposit.png)

   **Note:** Deposit functionality added but currently non-functional due to time constraints and prioritization of critical banking features.








   
