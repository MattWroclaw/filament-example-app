0. https://www.youtube.com/watch?v=c_hL4wKYfHY&list=WL&index=7&t=2s
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
 16. Control layout of form. PostResource, method `form()` . *Note* `Section::make` always takes whole width. `Group` keeps things in the same column  
 17. Relation Manager [one::many], create manager `php artisan make:filament-relation-manager CategoryResource posts title`   In app/Filament/Resources/RelationManagers/PostsRelationManager.php is created
 Output:    INFO  Make sure to register the relation in `CategoryResource::getRelations()`. -> we do this in `getRelations()` method . Now in Post Categories>Edit we see Posts frm given Category. An we can even cretae Posts in here. 
 18. Many:many [posts::users]. 
    1. create migration `php artisan make:migration create_post_user_table --create=post_user` and this will create database/migrations/create_post_user_table migration.  We add this `foreignIdFor` to the migration class. 
    2. we migrate our database with command `php artisan migrate`
    3. we define relationships `belongsToMany` in models (Post, Users)
    4. adding Authors section in Posts resource in `form()` method.
    20. we can do the same with relatioship manager(this is a single resource file that handles relationships ) : `php artisan make:filament-relation-manager`. This will give interactive commands like so:  
     php artisan make:filament-relation-manager

  What is the resource you would like to create this in?
❯ PostResource

  What is the relationship?
❯ authors

  What is the title attribute?
❯ name

   INFO  Filament relation manager [C:/Projects/Playground/filament-example-app/app/Filament/Resources/PostResource/RelationManagers/AuthorsRelationManager.php] created successfully.

   INFO  Make sure to register the relation in `PostResource::getRelations()`.  
   **app\Filament\Resource\PostResource\RelationsManagers\AuthorsRelationManager.php** <-- new file just created. *Register* in PostResource.php in `getRelations` method.

 19. **Pivots** We add `$table->integer('order')->default(0);` We run migration `php artisan migrate:refresh --step=1` this re-reuns last migration.  Then we need to define Pivots in the both models, like this `->withPivotValue(['order'])` . We add ` TextInput::make('order')->numeric(),` to AuthorsRelationManager. 