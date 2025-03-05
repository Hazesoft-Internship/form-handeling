
### Form handling
- Create a form to send a user data
	- First name
	- Middle name
	- last name
	- address
	- email
	- There should be database (Mysql)
		- Table name "users"

- There should be validation for each fields.
- There should also be script that inserts 10,000 rows of users.
	- Data sets should have full_name, But when inserting user it should separate into first_name, middle_name and last_name.
	- Data set example:
		- Full Name, Address, Email
		- Rupesh Shrestha, Kathmandu, rupesh.shrestha@hazesoft.co
		- ....
	- Data set should be in csv file.

- There should be constructor promotion.
- Coding Style should strictly follow PSR-12. https://www.php-fig.org/psr/psr-12/
- Conventional Commit should strictly followed. https://www.conventionalcommits.org/en/v1.0.0/

- There should be specific class to insert 10,000 rows
	- It should be initialized by `php InsertUser.php`

### Run php script
- `php -S localhost:{PORT}`
- `php InsertUser.php`
