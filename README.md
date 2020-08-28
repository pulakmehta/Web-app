# A comprehensive Web Application
## PHP - Bootstrap - MySQL - JavaScript

* **Developed by:** *Kunal Ninawe and Pulak Mehta*
* **Course Name:** *CS-GY-6083- Principles of Database Systems*
* **Development environment:** *WAMP Server (Windows Apache MySQL PHP)* 
* **Programming:** PHP 
* **Scripting:** 
*JavaScript and PHP*
* **Database used:** *MySQL*
* **Designing Tool:** *HTML5, CSS3 and Bootstrap* 
* **Code Editor:** Sublime Text3 and Visual Studio Code 

**Objectives:**
*This insurance website can broadly do these follow tasks:*
* To create a web-based user interface for the database schema.
* In particular, users should be able to register, login, buy an insurance, browse and search their insurances and other content that is accessible to them. 
* User could be either customer or employee of WDS, create and authenticate customers and employees by providing necessary validations.
* Perform *CRUD*(Create-Read-Updated-Delete) operations for Auto and Home Insurances.
* Add information for Vehicles, their drivers and Houses of the customer, and then use these assets to avail an insurance.
* Data Vizualization using Google Charts.

**Summary of the features used:**
Below is a list of features that we have implemented in the website – 
* Login/Register authentication. 
* Md5 Password encryption. 
* Using prepared Statements to prevent SQL injections. 
* User Friendly Beautiful UI Design. 
* Data Visualization. 
* Handling dependent data (Eg: If vehicles are removed, its corresponding drivers will also be removed). 
* CRUD operations used. 
* Data Validation before storing data.
* Security of data.
* Automated session logout. 
* Update synchronization (i.e. When assets are added into current ins, all payments, invoice and insurance amounts which are unpaid will be updated accordingly). 
* Customized cost generation for each user, and quote shown in a bill format for better UI. 
* MVC format file structure. 
* Code well formed, used functions to reduce redundancies.
* Created pages of Error:401, 404 and 500.


**List of tables in our database:**
* *cust_details:* To store the details of the customers like email, password, etc.
* *home_details:* To store the details of the customer's houses.
* *vehicles:* To store the details of the customer's vehicles.
* *Drives:* To store the details of all the vehicle's drivers.
* *Admin:* To store details about the admins using this system.
* *Home_ins:* To store the details about the home insurances of the customers.
* *Auto_ins:* To store the details about the auto insurances of the customers.
* *Home_ins_payments:* To store the details about the payments for the home insurances. This table can also act as invoice table.
* *Auto_ins_payments:* To store the details about the payments made for the auto insurances. This table can also act as an invoice table.
