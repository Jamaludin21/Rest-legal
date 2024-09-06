# CodeIgniter 4 REST API with User Flow and Midtrans Integration

This project is a RESTful API built with CodeIgniter 4. It includes user flow functionalities (login, registration, update, and delete) and integrates Midtrans as a payment gateway for handling transactions. The project is structured with environment-based configuration, secured authentication, and RESTful responses.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Database Structure](#database-structure)
- [Usage](#usage)
  - [User Flow](#user-flow)
  - [Midtrans Payment Integration](#midtrans-payment-integration)
- [Routes](#routes)
- [Security Considerations](#security-considerations)
- [Postman API Documentation](#postman-api-documentation)

## Features

- User authentication (register, login)
- Update and delete user information
- Integration with Midtrans for payment gateway
- Environment-based configuration for Midtrans API keys
- RESTful response structure with JSON formatting

## Requirements

- PHP 8+
- CodeIgniter 4
- Composer
- MySQL/MariaDB (or another relational database)
- Midtrans account (for payment integration)

## Database MySQL Query

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    transaction_id VARCHAR(255),
    status VARCHAR(50),
    amount DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

## Usage
User Flow
Register: Create a new user by sending a POST request with username, email, and password.
Login: Authenticate the user by sending email and password, and receive a response indicating success or failure.
Get All Users: Read user's information by sending a GET request
Get Users: Read user's information by sending a GET request with user's ID
Update User: Update user information by sending a PUT request with the user's ID and the updated information.
Delete User: Delete a user by sending a DELETE request with the user's ID.

Midtrans Payment Integration
Charge Payment: Send a POST request with payment details (such as amount and customer details) to generate a payment transaction.

## Routes
The following RESTful routes are available in this API:
Method	Route	Description
POST	/user/register	Register a new user
POST	/user/login	Login user
PUT	/user/update/{id}	Update user by ID
DELETE	/user/delete/{id}	Delete user by ID
POST	/payment/charge	Charge a payment

## Security Considerations
Make sure to hash passwords using the password_hash() function.
Use HTTPS to secure the communication between the client and the server, especially for sensitive operations like login and payment.
Implement token-based authentication (e.g., JWT) for securing the update and delete user routes.

## Postman API Documentation
You can test this API with Postman or any other API testing tool. Postman collections can be created to document and test the available endpoints.
