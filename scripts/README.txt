How to use these files:

1) Run commands to create database and setup tables
      mysql -u root -p < create_tables.sql

2) Run the Buzz API scraper to get the data from the api into a json file (takes a while)
      python buzzapi_scraper.py

3) Run script to insert data from the json file into the database tables
      python insert_buzzapi_data.py

4) Run commands to insert fake data into database (enrollments)
      mysql -u root -p < fake_data.sql

