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
* Request parameters
    * Handled Using the Utils\Request class
* Easy helper function support
    * helpers/
        * global.php
            * This file will always be available
        * Other files can be required if defined in controller
            * 'controller/Root.php' for more details
* Response types
    * Simple
        * Every PHP type
    * Complex
        * ViewRenderer
        * ResponseType
            * text/xml
            * text/json
            * text/html

### TODO
* Middleware
    * AUTH
        * Bearer auth
        * Token auth
        * Session auth
    * Custom
        * Allow creation of middlewares

### Routes

* Static route
    * `/test/page`
* Dynamic route
    * `/test/{id}`  
    * `/test/{id:string}`
    * `/test/{id:int}`
    * `/test/{id:}`

*The type string is not necessary as everything without a type is a string, but can be useful to help document routes and prevent future bugs.*