1. php.ini -> ucnomment 2 things: .zip & something else
2. create project via `php artisan create...`
3. Create filament:
   1. `composer require filament/filament:"^3.2" -W`
   2. `php artisan filament:install --panels` 
4. .env => unable the DB, then `php artisan migrate` to create tables for user.  
5. Create user: `php artisan make:filament-user` . Now you are able to login to `localhost:8000/admin` 
6.  See all new commends by `php artisan make` 
    1. `make:filament-resource`          Create a new Filament resource class and default page classes. Creates CRUD page for model in DB
    2. do this -> `php artisan make:filament-resource User`. This will create ./app/Filament/Resources/UserResources/UserResource.php file. On the main view, there is a new section `Users` 
7. Inside `UserResource.php` will be defined DB schema. If you create "categoroy" then there will be a `CategoryResource.php`... this file will define what you see in CRUD pages.
   * $navigationIcon = 'heroicon-o-rectangle-stack' -> navigation icon  
   * form(Form $form): Form -> used to define create and update operations
   * function table(Table $table): Table ->columns : defines what should be visible in the table in Users view. 