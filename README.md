# world-on-wheels

Project Topic: Bike Paths

Functionalities:
 - Authentication
 - Adding bike paths
 - Commenting and liking paths
 - Admin Panel: Managing all paths and comments
 - Author Panel: Managing own paths, comments on own paths, and personal comments

Software Versions (The application has not been tested for compatibility with earlier versions):
 - XAMPP (MySQL Database, APACHE Web Server)
 - PHP 7.3

Setup Instructions:
1. Place the project folder inside apache\htdocs.
2. Start XAMPP's MySQL Database and Apache Web Server.
3. Import the database from the world-on-wheels.sql file:
   - Open a browser and go to http://localhost/phpmyadmin.
   - Select New from the left panel.
   - Enter "world-on-wheels" (without quotes) in the Database name field.
   - Select utf8mb4_general_ci from the dropdown list.
   - Click Create.
   - Select the world-on-wheels database from the left panel.
   - Click Import from the top menu.
   - Drag and drop the world-on-wheels.sql file into the designated area.
   - Click Import at the bottom of the page.
4. Enable an internet connection for the application to function correctly.
5. Open the application in a browser at: http://localhost/project-folder/


Test Accounts:

Admin:<br>
Username: admin<br>
Password: Admin123

Regular user who has published some posts:<br>
Username: hopchana<br>
Password: Hopchana123<br>

Regular user who has not published any posts:<br>
Username: SuperUser<br>
Password: SUser123<br>

Test Data:<br>
The test-data archive contains sample data used for creating posts.<br>
Each bike path is stored in a separate folder. Inside each path folder, there are:
- Six images (one main image and five for content).
- A .gpx file (a text file containing geographic route information).
- A .txt file (information used for writing the post).
- Structure of the .txt file:
- Path Title  
- Starting Point  
- Ending Point  
- Distance, Unit of Distance  
- Short Description  
- Description extension (combined with the short description to form a full description)  
- Markers to be placed on the map:  
  - Latitude, Longitude  

Note:<br>
- The short and long descriptions must be unique for each path.<br>
- To reuse descriptions from a file, either delete the existing path or modify the descriptions.