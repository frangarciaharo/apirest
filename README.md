### OBJECTIU
# Endpoints

#### Books
```
GET /books
GET /books/{id}
POST /books
PUT /books/{id}
DELETE /books/{id}
```
#### Users
```
GET /users
GET /users/{dni}
POST /users
PUT /users/{dni}
DELETE /users/{dni}
```
#### Courses
```
GET /courses
GET /courses/{code_course}
POST /courses
PUT /courses/{code_course}
DELETE /courses/{code_course}
```

## APIREST

```
curl -d '{"id":1, "name":"Ramon"}' -H 'Content-Type: application/json' -X PUT http://localhost:8000
```