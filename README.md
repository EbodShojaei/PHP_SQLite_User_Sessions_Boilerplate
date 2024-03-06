# COMP3975 - Assignment 1

Inspired by last year's web series on session management with Node.js and MongoDB, this web app now features PHP and SQLite with a modular file directory utilizing object-oriented best practices and SOLID principles.

##### Node.js and MongoDB: 
-  Repo: **[Link](https://github.com/EbodShojaei/COMP2537_Assignment2_Modular.git)**

<br>

	 Author: Ebod Shojaei
	 Version: 1.0.1


## Features:
- The /admin page redirects to the /login page if not logged in.
	>  **Includes**:
	 > - The /admin page shows an error message if logged in, but not an admin
	 > - The /admin page shows a list of all users
	 > - The /admin page allows for authorizing and deauthorizing newly signed-up users    
 - All pages use a CSS Framework like Bootstrap (incorporates a header, footer, responsive grid, forms, buttons)
 	>  **Includes**:
	> - Common headers and footers are shared across all pages
	> - Code used within loop is templated using PHP (ex: list of users in admin page)
- The dashboard page allows users to manage transactions that are organizable into custom buckets
- A home page links to signup and login, if not logged in; and links to dashboard and signout, if logged in.
	>  **Includes**:
	> - use of parametrized query searches for protection against nosql-injection attacks
	> - use of collation option for case insensitive querying of 'name' in user info to prevent writing duplicate names into the database
	> - use of lowercase method for submitted emails to prevent writing duplicates into the database.

- A dashboard page with CRUD features that authenticated users can manage.
	> The dashboard page will redirect to the home page if no valid session is found.

- The signout buttons end the session.

- Password is BCrypted in the SQLite database.

- The site is hosted on Azure, a hosting service.

- A 404 page "catches" all invalid page hits and that sets the status code to 404.

- Session information is stored in an encrypted SQLite session database. Sessions expire after 1 hour.

<br>

## Resources
- **[COMP2537_Assignment 2 | Node.js and MongoDB](https://github.com/EbodShojaei/COMP2537_Assignment2_Modular.git)** by Ebod Shojaei
	- Used for directory setup
<br>

- **[ChatGPT-4](https://chat.openai.com/)** by OpenAI
	- Used for debugging
