import urllib2
import json
import time


def request(resource, params):
  url = 'https://api.gatech.edu/apiv3/central.academics.course_catalog.'
  request = url+resource+'/search?'+params+'api.app_id=degreepath-dev&api.app_password=Nkj6payxmdf&api_request_mode=sync'
  return request


# Variable to store all data
courses = []

# Get a list of all subjects
resource = 'subjects'
params = 'term_code='+time.strftime("%Y")+'02&'
response = urllib2.urlopen(request(resource, params)).read()

subjects = (json.loads(response))["api_result_data"]

for s in subjects:

  subject = s["subject_code"]

  print subject
  
  resource = 'classes'
  params = 'term_code='+time.strftime("%Y")+'02&subject='+subject+'&'
  response = urllib2.urlopen(request(resource, params)).read()

  if "api_result_data" in (json.loads(response)).keys():
    for course in (json.loads(response))["api_result_data"]:
      courses.append(course)
    print len(courses)
  else:
    print 0



# Write data to json file
name = 'courses.json'
file = open(name, 'w')
file.write(json.dumps(courses, indent=4, sort_keys=True))

file.close()
