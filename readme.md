# Gravity2 V0.0.1

### Features
* Full dynamic routing
    * Routes can contain (typed)dynamic parameters
* Mysql PDO
    * Connection
    * Querys
* ini.json
    * Sensitive data
        * Password
        * Email
        * Tokens
        * Ids

### TODO
* View Rendering system
    * Templates
* POST METHOD
    * Handle params
* More types on routes
    * Dates

### Routes

* Static route
    * `/test/page`
* Dynamic route
    * `/test/{id}`  
    * `/test/{id:string}`
    * `/test/{id:int}`
    * `/test/{id:}`

*The type string is not necessary as everything without a type is a string, but can be useful to help document routes and prevent future bugs.*