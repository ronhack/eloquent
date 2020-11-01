<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Post;

Route::get('/eloquent', function () {
    $posts = Post::all();// con all() obtenemos todos los datos de la tabla
    // si queremos algo más personalizado podemos usar
    // Post::where("id", ">=", "6")->get() donde el número es el elemento que deseamos filtrar
    // Post::where("id", ">=", "6")->orderBy("id", "desc")->get() ordenando los registros por id de forma descendente
    // Post::where("id", ">=", "6")->orderBy("id", "desc")->take(3)->get() con take() obtenemos el numero de registros que pasemos como parametro
    // en este caso se obtienen 3

    foreach($posts as $post){
        echo "$post->id $post->title <br>";
    }
});

// ver los posts y quien los hizo
Route::get('eloquent/posts', function () {
    $posts = Post::get();

    foreach($posts as $post){
        echo "
        $post->id
        <strong>{$post->user->name}</strong>
        $post->title <br>";
    }
});


/* Contar cuantos posts tiene cada usuario */
use App\Models\User;
Route::get('eloquent/users', function () {
    $users = User::all();

    foreach($users as $user){
        echo "
        $user->id
        <strong>$user->name</strong>
        {$user->posts->count()} posts <br>";
    }
});

/* Codigo apartir de clase de Colecciones y serialización de datos */
Route::get('eloquent/collections', function () {
    $users = User::all();

    //dd($users);

    #dd($users->contains(4)); // para verificar si la colección tiene el elemento numero 4
    #dd($users->except([1, 2, 3])); // trae todos los elementos que no sean los que están entre los corchetes
    #dd($users->only(4)); // solamente el numero 4
    #dd($users->find(4)); // buscar unicamente el numero 4
    dd($users->load('posts')); // buscar unicamente el numero 4

});

/* Serialización */

Route::get('eloquent/serialization', function () {
    $users = User::all();

    #dd($users->toArray()); // serializacion en arrays

    $user = $users->find(1);
    #dd($user);
    dd($user->toJson()); // serializacion para retornar un json

    // colecciones son una pequeña extension de eloquent que te permiten
    // manipular fácilmente los datos

    // y la serializacion es la forma como presentamos estos datos,
    // ya sea en Arrays o Json

});