<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
</head>
<body>

  <h1>🎓 ZU Portal: Learning Management System</h1>
  <p><strong>ZU Portal</strong> is a web-based Learning Management System (LMS) designed to manage academic activities in a university setting. Built with PHP, HTML, CSS, JavaScript, and powered by MySQL, it allows administrators to manage students, courses, units, timetables, and generate academic reports.</p>

  <h2>🎯 Features</h2>
  <ul>
    <li>Student registration and login</li>
    <li>Admin panel for managing students, courses, and units</li>
    <li>Timetable management</li>
    <li>Academic report generation</li>
    <li>Responsive design for various devices</li>
  </ul>

  <h2>📁 Project Structure</h2>
  <pre>
LMS/
├── admin/              --> Admin panel files
├── assets/             --> Images and other assets
├── css/                --> Stylesheets
├── database/           --> SQL files for database setup
├── includes/           --> PHP include files
├── js/                 --> JavaScript files
├── index.php           --> Homepage
├── login.php           --> Login page
├── logout.php          --> Logout script
├── logout_now.php      --> Logout now script
├── profile.php         --> User profile page
├── register.php        --> User registration page
├── timetable.php       --> Timetable management page
├── units.php           --> Units management page
└── LICENSE             --> License file
  </pre>

  <h2>⚙️ Installation</h2>
  <ol>
    <li>Clone the repository:
      <pre><code>git clone https://github.com/Vexx-bit/LMS.git</code></pre>
    </li>
    <li>Set up a MySQL database and import the provided SQL file:
      <ul>
        <li>Create a new database (e.g., <code>zu_portal</code>)</li>
        <li>Import the SQL script located in the <code>database/</code> directory</li>
      </ul>
    </li>
    <li>Configure the database connection:
      <ul>
        <li>Open the relevant configuration file in the <code>includes/</code> directory</li>
        <li>Update the database credentials accordingly</li>
      </ul>
    </li>
    <li>Run the application:
      <ul>
        <li>Place the project folder in your web server's root directory (e.g., <code>htdocs</code> for XAMPP)</li>
        <li>Start your web server and navigate to <code>http://localhost/LMS/</code></li>
      </ul>
    </li>
  </ol>

  <h2>📄 License</h2>
  <p>This project is licensed under the terms of the <a href="https://github.com/Vexx-bit/LMS/blob/main/LICENSE">MIT License</a>.</p>

  <p>Developed with ❤️ by Samuel Kang'ethe (<a href="https://github.com/Vexx-bit">Vexx-bit</a>)</p>

</body>
</html>
