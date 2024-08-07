![Gravity logo](public/assets/img/logo.png)

# Gravity2(0.0.1.alpha1)

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
* POST METHOD
    * Handle params
        * Handled Using the Utils\Request class

### TODO
* Response types
* Middleware
    * Bearer auth
    * Token auth
    * Session auth

### Routes

* Static route
    * `/test/page`
* Dynamic route
    * `/test/{id}`  
    * `/test/{id:string}`
    * `/test/{id:int}`
    * `/test/{id:}`

*The type string is not necessary as everything without a type is a string, but can be useful to help document routes and prevent future bugs.*