### Instruções

+ Utilizei Laravel 4.2.4, PHP 8.0.3 e SQLite
+ Aprendi com base neste webinar: https://www.youtube.com/watch?v=mgdMeXkviy8
+ Navegue com o terminal até a pasta raíz, faça o comando "composer i && php artisan key:generate && php artisan serve", aguarde e vá ao endereço http://127.0.0.1:8000/api/v1/posts/2 para testar.

### Iniciar projeto

+ 1: Mover-se para a pasta de projetos e criar um projeto novo: ```cd Z:\laravel_projects && laravel new vini-api```
+ 2: Abrir VS Code: ```code .```

### Desenvolver a API

+ 1: Criar Post model e migration: ```php artisan make:model Post -m```
+ 2: Inserir/alterar campos na blueprint da migration em .\database\migrations\2021_04_04_171849_create_posts_table.php:
```
Schema::create('posts', function (Blueprint $table) {
    $table->id();
    
    $table->string('title');
    $table->string('slug')->unique();
    $table->integer('likes')->default(0);
    $table->string('content')->nullable();

    $table->timestamps();
});
```
+ 3: Editar .env e setar: ```DB_CONNECTION=sqlite``` por ser mais fácil para trabalhar localmente
+ 4: Criar arquivo database.sqlite em ./database
+ 5: Realizar mudanças: ```php artisan migrate```
+ 6: Editar app\Models\Post.php para que Laravel saiba o que temos em nossa database:
```
protected $fillable = [
    'title',
    'slug',
    'likes',
    'content',
];

protected $casts = [
    'likes' => 'integer',
];
```
+ 7: Criar controlador para dividir responsabilidades: ```php artisan make:controller PostController --api```
+ 8: Agora que nosso controlador foi criado em app\Http\Controllers\PostController.php, precisamos apontar rotas CRUD da api(routes\api.php) para o mesmo:
```
Route::prefix('v1')->group(function () {
    Route::apiResource('posts', 'App\Http\Controllers\PostController');
});

/**
 *  OBS: O código deste arquivo pode exigir mudanças, dependendo da sua versão do Laravel.
 *  Leia sobre em: https://laravel.com/docs/8.x/upgrade#routing
 *  Os dois exemplos a seguir funcionam:
 *  Route::get('/posts', 'App\Http\Controllers\PostController@index');
 *  Route::get('/posts', [App\Http\Controllers\PostController::class, 'index']);
 *  Mas os exemplos abaixo não funcionam na última versão do Laravel:
 *  Route::get('/posts', 'PostController@index');
 *  Route::resource('posts', 'PostController');
 *  O código abaixo permite a mesma função da Route::resource(), porém, mais personalizado:
 *  use App\Http\Controllers;
 *  Route::post('/posts', [Controllers\PostController::class, 'store']);        // Create
 *  Route::get('/posts', [Controllers\PostController::class, 'index']);         // Read
 *  Route::put('/posts', [Controllers\PostController::class, 'update']);        // Update
 *  Route::delete('/posts', [Controllers\PostController::class, 'destroy']);    // Delete
 */
```
+ 9: Podemos testar o código acima com o comando ```php artisan route:list``` e devemos ter o seguinte resultado:
```
+--------+-----------+------------------+---------------+---------------------------------------------+------------+
| Domain | Method    | URI              | Name          | Action                                      | Middleware |
+--------+-----------+------------------+---------------+---------------------------------------------+------------+
|        | GET|HEAD  | /                |               | Closure                                     | web        |
|        | GET|HEAD  | api/posts        | posts.index   | App\Http\Controllers\PostController@index   | api        |
|        | POST      | api/posts        | posts.store   | App\Http\Controllers\PostController@store   | api        |
|        | GET|HEAD  | api/posts/{post} | posts.show    | App\Http\Controllers\PostController@show    | api        |
|        | PUT|PATCH | api/posts/{post} | posts.update  | App\Http\Controllers\PostController@update  | api        |
|        | DELETE    | api/posts/{post} | posts.destroy | App\Http\Controllers\PostController@destroy | api        |
|        | GET|HEAD  | api/user         |               | Closure                                     | api        |
|        |           |                  |               |                                             | auth:api   |
+--------+-----------+------------------+---------------+---------------------------------------------+------------+
```
+ 10: Importar model Post no controlador PostController.php:
```
use App\Models\Post;
```
+ 11: Modificar funções no controlador PostController.php:
```
public function index()
{
    return Post::all();
}

public function store(Request $request)
{
    $request->validate([
        'title' => 'required'
    ]);

    return Post::create($request->all());
}

public function show($id)
{
    return Post::find($id);
}

public function update(Request $request, $id)
{
    $post = Post::find($id);
    $post->update($request->all());
    return $post;
}

public function destroy($id)
{
    return Post::destroy($id);
}
```