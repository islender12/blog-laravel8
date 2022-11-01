<?php

namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PageController extends Controller
{
    // Retorna Todos los Posts
    public function posts(Request $request){

        $TotalPaginas = Post::with('user')->paginate(5)->lastPage();

        // Si la pagina es mayor al total de paginas regresame
        // Por si cambian por url la pagina a una que no exista
        // Solo hay 5 paginas
        // Ejemplo ?page=5 si cambia ?page=6 lo regresará pues no existe pagina 6

        if($request->page > $TotalPaginas){
            return back();
        }

        // El metodo with nos permite traer los datos con su relacion
        return view('posts',[
            'posts' => Post::with('user')->latest()->paginate(5)
        ]);
    }

    // Retorna un post en especifico
    public function post(Post $post){

        // La consulta se hace arriba (Post $post)

        return view('post',[
            'post' => $post
        ]);

    }
}
