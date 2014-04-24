How to use these files:

1) Run commands to create database and setup tables
      mysql -u root -p < create_tables.sql

2) Run the Buzz API scraper to get the data from the api into a json file (takes a while -- skip this step if courses.json is already populated)
      python buzzapi_scraper.py

3) Run script to insert data from the json file into the database tables
      python insert_buzzapi_data.py

4) Run script to scrape Buzz API and insert prerequisite data (takes a REALLY long time -- about 10-15 minutes)
      php InsertPrerequisitesDetails.php

5) Run script to scrape Course Critique and insert GPA data
      php InsertCoursesGPA.php

6) Run commands to insert fake data into database (users, enrollments)
      mysql -u root -p < fake_data.sql

