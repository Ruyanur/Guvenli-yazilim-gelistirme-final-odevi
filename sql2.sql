select*from user_management.products

SELECT * FROM user_management.users WHEREpassword='123'

set SQL_SAFE_UPDATES=1;

update user_management.users
set password = '123'
where username = 'taha';