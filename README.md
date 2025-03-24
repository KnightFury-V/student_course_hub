## Web_Project-GROUP 4

## Student Course Hub Web Application
**Setup Instructions**

**Create the Database**
* Execute the SQL commands in the student_course_hub.sql file to create the database and tables.

**Database Credentials**
* Update the database credentials in db_connect.php with your database username and password if changed or required.

**File Structure**
* Make sure all files are located in your web server's root directory (e.g., htdocs for XAMPP).

**Description of Files**
* student_course_hub/index.php - Displays available programs and allows students to register or withdraw interest and entry for page to login admin and staff. It is homepage of the website.
* student_course_hub/module.php - Displays details of a specific module and the programs it is involved in.
* student_course_hub/program.php - Displays details of a specific program, including modules also the program in which modules are involved.
* student_course_hub/register_interest.php -  Handles student registration of interest in a program.
* student_course_hub/search.php -  Displays search results for programs.
* student_course_hub/withdraw_interest.php -  Handles student withdrawal of interest in a program.
* ./admin/ - This folder consist all the CRUD functionalities for modules and programs for admin, login pages with options for staff and admin, file that allows superusers to create admin user accounts, admin dashboard, file for admin to create staff user accounts, student.php file to view all the interested students, files for staff dashboard, logout also a landing page for admin(index.php), also file for exporting the interested student list.

* ./css/- This folder consist all the css styling files for different pages
* ./images/- This folder consist all the images for programs, modules and background.
* ./includes/- This folder consist database connection file and file with some function which are required to fetch Staffname, Levelname, ProgramName and checking if the user is Super user or not.


**Access the Application**
* Open your web browser and navigate to http://localhost/student_course_hub/index.php to access the application.


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
 
**STAFF PANEL**
* Provides overview of programs and modules they are leading and involved in.
  
 
**Responsive Design:** 
* Ensures the website looks and functions well on various devices.

**Security**
* Basic input validation is implemented to ensure correct email format and required fields.
* htmlspecialchars() function anmd isSet with FILTER_SANITIZE_FULL_SPECIAL_CHARS is implemented to sanitize the user input to secure form Cross-site scripting vulnerability.
