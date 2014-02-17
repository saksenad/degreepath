import json
import MySQLdb

db = MySQLdb.connect(host="localhost", user="root", passwd="root", db="degreepath")
cur = db.cursor()

name = 'courses.json'
file = open(name, 'r')

courses = json.loads(file.read())
for course in courses:
  result = cur.execute("SELECT * FROM courses WHERE subject='"+course['subject_code']+"' AND course_number="+course['course_number'])
  if result == 0:
    query = "INSERT INTO courses(subject, course_number, name) VALUES('"+course['subject_code']+"', "+course['course_number']+", '"+course['course_title'].replace("'", "")+"');"
    cur.execute(query)

db.commit()
