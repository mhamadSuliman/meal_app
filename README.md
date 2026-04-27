شرح تفصيلي احترافي لـ GitHub README
🧠 Project Overview

This project is a complete restaurant ecosystem platform designed to manage the full lifecycle of food ordering — from browsing restaurants to placing orders and handling delivery.

The system supports multiple user roles and provides both:

🌐 Web dashboards (Admin / Owner / Delivery)
📱 REST API (for mobile apps)
🏗 Architecture

The project is divided into two main parts:

1. Web Application (Blade + Laravel)
Admin Dashboard
Restaurant Owner Dashboard
Delivery Dashboard
2. REST API (Laravel API)
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
