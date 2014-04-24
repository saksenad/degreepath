import json
import MySQLdb

db = MySQLdb.connect(host="localhost", user="root", passwd="root", db="degreepath")
cur = db.cursor()

name = 'courses.json'
file = open(name, 'r')

courses = json.loads(file.read())
for course in courses:
  result = cur.execute("SELECT * FROM courses WHERE subject='"+course['subject_code']+"' AND course_number='"+course['course_number']+"'")
  if result == 0:
    credit_hours = str(max(course['catalog_credit_hour_low'], course['catalog_credit_hour_high']))
    GPA = "3.00"
    prereqs = "[ ]"

    query = "INSERT INTO courses(subject, course_number, name, credit_hours, GPA, prereqs, course_CRN) VALUES('"+course['subject_code']+"', '"+course['course_number']+"', '"+course['course_title'].replace("'", "")+"', "+credit_hours+", "+GPA+", '"+prereqs+"', "+course['crn']+");"
    cur.execute(query)

db.commit()
