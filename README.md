##Student Course Hub Web Application**
**Setup Instructions**

**Create the Database**
Execute the SQL commands in the localhost.sql file to create the database and tables.

**Database Credentials**
Update the database credentials in db_connect.php with your database username and password if changed.

**File Structure**
Make sure all files are located in your web server's root directory (e.g., htdocs for XAMPP).

**Access the Application**
Open your web browser and navigate to index.php to access the application.


## Features

**FOR STUDENTS**
* **Course Listings:** Displays available educational programs with details and images.
* **Search Functionality:** Allows users to search for programs.
* **Interest Registration:** Enables users to register their interest in specific programs.
* **Interest Withdrawal:** Allows users to withdraw their interest in programs.


**ADMIN PANEL** 
    * Provides administrative tools for managing programs, modules, and user data.
    * Create, read, update, and delete programs.
    * Create, read, update, and delete modules.
    * User authentication for admin access.
    * View and manage interested student registration data.
    * Export the information of interested student
 

* **STAFF PANEL**
*  Provides overview of programs and modules they are leading and involved in.
  
 
* **Responsive Design:** Ensures the website looks and functions well on various devices.

**Security**
* Basic input validation is implemented to ensure correct email format and required fields.
* htmlspecialchars() function anmd isSet with FILTER_SANITIZE_FULL_SPECIAL_CHARS is implemented to sanitize the user input to secure form Cross-site scripting vulnerability.
