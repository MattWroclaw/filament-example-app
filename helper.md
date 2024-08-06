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
   * in UserResource.php `form(Form $form)` -> `schema` create fields that will be in `Create User` view (form).
8. Creating Users view (table) inside `function table(Table $table) { $table->columns([....])}
9. Creating 2 new models 
    * tworzenie migrate dla Post: `php artisan make:model Post -m`
    * twprzenie migrage dla Category: ` php artisan make:model Category -m`
    * Category model. `php artisan make:filament-resource Category` (Filament/Rosurces is there, tab on the sidebar is visible but the Model is not created yet)
    * Post model  `php artisan make:filament-resource Post` 
10. Fixing the Error
Class "App\Models\Post" not found -> `php artisan migrate` 
11. The Post & Categories view are now available (thou empty)
12. Fill out CategoryResource.php `form()` with ->schema, TextiInput.. and in `table()` -> TextColumn..
13. In Post model we need to implement `$fillable= ['title' ' 'slug' , 'color'...] ` We do the same in `PostResource.php` for `form()` [TextInput]  and `table()` [ColunmInput] methods. **Warning** need to handle deletion of files on delete-post
14. Files issue 
 * -> need to link storage(?) `php artisan storage:link` --> link has been connected to [C:\Projects\Playground\filament-example-app\storage\app/public].
 * -> in `.env` make sure this is right: `APP_URL=http://127.0.0.1:8000` when there is `localhost` and in browser IP, then it is not loading for Update view. 

 15. To make category name make visble on Posts view we need to add in Post model in `category()` method this relationship chunk `$this->belongsTo(Category::class);`