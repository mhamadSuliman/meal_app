🧠 Project Overview

This project is a complete restaurant ecosystem platform designed to manage the full lifecycle of food ordering — from browsing restaurants to placing orders and handling delivery.

Screens:
<img width="1366" height="768" alt="Screenshot (155)" src="https://github.com/user-attachments/assets/378c1e87-aad5-431e-90f5-027dee15c228" />
<img width="1366" height="768" alt="Screenshot (154)" src="https://github.com/user-attachments/assets/d1a6fc37-a1b8-4212-86ee-e75ea0f69f53" />
<img width="1366" height="768" alt="Screenshot (153)" src="https://github.com/user-attachments/assets/13063262-4fa9-42b0-9dc4-e03c4eb75b1a" />
<img width="1366" height="768" alt="Screenshot (152)" src="https://github.com/user-attachments/assets/964ec257-57f3-40c5-a840-d353055fe92f" />
<img width="1366" height="768" alt="Screenshot (151)" src="https://github.com/user-attachments/assets/6cb7b55c-a762-42c4-abd8-a56bdcd585ec" />
<img width="1366" height="768" alt="Screenshot (150)" src="https://github.com/user-attachments/assets/65286ac5-6672-4f41-9a9a-97a1576f8221" />
<img width="1366" height="768" alt="Screenshot (149)" src="https://github.com/user-attachments/assets/9dea8276-9f82-40b9-b327-c721e46e889a" />
<img width="1366" height="768" alt="Screenshot (148)" src="https://github.com/user-attachments/assets/8153bf56-bdba-4b98-b083-29500f4ac515" />
<img width="1366" height="768" alt="Screenshot (147)" src="https://github.com/user-attachments/assets/71b09904-7d9a-488c-a6fa-571a597d93ed" />
<img width="1366" height="768" alt="Screenshot (146)" src="https://github.com/user-attachments/assets/60e7fe6d-efe5-4f44-a023-76ae2ca61bb3" />
<img width="1366" height="768" alt="Screenshot (145)" src="https://github.com/user-attachments/assets/5a9fbc14-ee92-4b21-b446-e8335cdb5ddb" />
<img width="1366" height="768" alt="Screenshot (144)" src="https://github.com/user-attachments/assets/b6336300-99f0-4f96-bf8e-954d1a50eccf" />
<img width="1366" height="768" alt="Screenshot (143)" src="https://github.com/user-attachments/assets/74d43ec0-6036-4d2f-a427-f4f0379e3e9c" />
<img width="1366" height="768" alt="Screenshot (142)" src="https://github.com/user-attachments/assets/67121404-e841-47d0-91ca-74d936037376" />
<img width="1366" height="768" alt="Screenshot (141)" src="https://github.com/user-attachments/assets/c10b428a-c709-49e1-8d03-605686770544" />
<img width="1366" height="768" alt="Screenshot (140)" src="https://github.com/user-attachments/assets/0e781fd6-cd59-4e02-a952-aac59a4394bd" />
<img width="1366" height="768" alt="Screenshot (139)" src="https://github.com/user-attachments/assets/50d3a444-fe78-43f5-8124-a87b979fb270" />
<img width="1366" height="768" alt="Screenshot (138)" src="https://github.com/user-attachments/assets/359200fc-0b17-4bbf-a79f-7fbab84d668b" />
<img width="1366" height="768" alt="Screenshot (137)" src="https://github.com/user-attachments/assets/ca3e3e37-f2e5-47d7-91e0-44c5464841a3" />
<img width="1366" height="768" alt="Screenshot (136)" src="https://github.com/user-attachments/assets/81ae4cec-264c-47fb-9c92-871b8f80c3ff" />


The system supports multiple user roles and provides both:

🌐 Web dashboards (Admin / Owner / Delivery)
📱 REST API (for mobile apps)
🏗 Architecture

The project is divided into two main parts:

 Web Application (Blade + Laravel)
 
Admin Dashboard

Restaurant Owner Dashboard

Delivery Dashboard

 REST API (Laravel API)

Mobile-ready endpoints

Token-based authentication (Sanctum)

👥 User Roles

🧑‍💼 Admin

Manage restaurants (Create / Update / Delete)

View all orders

Accept / Reject orders

Manage meals globally

🍔 Restaurant Owner

Manage their restaurant

Add / edit / delete meals

View daily revenue and statistics

Track today's orders

Dashboard analytics:

Today's revenue

Total revenue

Orders count

Average meal price

🚚 Delivery

Receive delivery requests

Accept / reject orders

Update delivery status

👤 User (Customer)

Browse restaurants

Filter by city

View meals

Add to cart

Place orders

Track order status

⚙️ Core Features

🍽 Restaurant System

List all restaurants

Filter by city

Top-rated restaurants endpoint

Restaurant details with meals

🍕 Meal Management

Add / edit / delete meals

Meal types:

Food

Drink

Dessert

Image support (storage system)

Dynamic UI with animated cards

🛒 Cart System

Add items to cart

Update quantity

Remove items

View full cart

📦 Order System

Create order from cart

Track order details

Update order status

Refund system (Admin / Owner)

🔔 Notifications

User notifications system

Mark as read

Real-time ready (broadcast channels)

🌍 Location System

Countries & cities APIs

User selects city

Restaurants filtered by city

💳 Payment Integration

Stripe webhook support

Payment confirmation endpoint

Ready for real-world payment flow

🔐 Authentication & Security

Laravel Sanctum authentication

Role-based access control

Protected API routes

Middleware:

auth:sanctum

role-based

city-selected

🎨 UI Highlights

Owner Dashboard

Advanced animated UI

Real-time statistics

Meal cards with:

Images

Hover effects

Dynamic pricing display

Admin Panel

Clean management interface

Filtering system

Restaurant grid view

Restaurant Page

Add meals inline

Edit & delete dynamically

Minimalistic dark UI

