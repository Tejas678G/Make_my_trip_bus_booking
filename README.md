# Make_my_trip_bus_booking
Project Overview:  
This project is a web-based bus booking system built using PHP and MySQL. It consists of two main modules:  
1. `login_page` – Manages user authentication and access control.  
2. `bus_booking` – Handles bus search, scheduling, availability, and booking functionality.
The primary goal of this project is to simulate a basic MakeMyTrip-style application, allowing users to log in and book bus tickets based on source, destination, and availability.
Folder Structure:  
- `/login_page`: Contains the login form and PHP backend logic for user authentication.  
- `/bus_booking`: Contains booking logic, bus availability lookup, and database interaction for user bookings.
Integration:  
- The two modules are integrated using a button-based navigation flow.  
- Upon successful login from `login_page`, users are redirected to `bus_booking/index.php` to search and book buses.  
- User sessions are maintained to ensure that only logged-in users can access booking features.

Database Setup:  
- The MySQL database must be imported using the provided SQL file `bus_booking.sql`.  
- This includes tables for `users`, `buses`, `bookings`, and possibly `cities`.  
API Integration:  
This system is designed to support API integration for bus data.  
Features include:  
- Retrieving bus schedules, locations, and ETA using GET requests.  
- Submitting bookings through POST requests to a backend script (e.g., `book_bus.php`).  
API endpoints can be used internally or by third-party services for expanding the system.

Usage Instructions:  
1. Install and start XAMPP (Apache + MySQL).  
2. Copy both folders (`login_page` and `bus_booking`) into the `htdocs` directory.  
3. Open phpMyAdmin and import the `bus_booking.sql` file.  
4. Run the app by navigating to:  
   http://localhost/login_page  
Notes:  
- Session handling ensures that unauthenticated access to `bus_booking` is prevented.  
- Future enhancements can include route mapping, payment integration, and admin dashboards.
