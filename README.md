### OBJECTIU
# Endpoints

```
GET /books ---------> Recursos disponibles
GET /books/{id} ----> El recurso id
POST /books --------> Crea un recurso con parametros body
PUT /books/{id} ----> Modificar el recurso con algunos parametrs
DELETE /books/{id}--> Elimar recurso
```


## APIREST

```
curl -d '{"id":1, "name":"Ramon"}' -H 'Content-Type: application/json' -X PUT http://localhost:8000
```