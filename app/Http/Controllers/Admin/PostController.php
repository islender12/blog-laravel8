<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Intervention\Image\Facades\Image;

// Nos permite eliminar una imagen o manipular la carpeta storage
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::Orderby('id', 'desc')->get();

        return view('adminposts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminposts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //Salvar
        $post = Post::create([
            'user_id' => auth()->user()->id,

        ] + $request->all());

        // Imagen

        // Si tenemos una Imagen
        // Recibimos la imagen y almacenamos la ruta de la imagen en el campo image de la base de datos
        // La imagen quedara almacenana en storage/public/posts/xxxxxxx.jpg

        // if ($request->file('file')) {
        //     $post->image = $request->file('file')->store('posts', 'public');
        //     $post->save();
        // }

        // Usamos este nuevo metodo del paquete intervention/image
        // para optimizar y comprimir las imagenes

        if ($request->file('file')) {
            $ruta = storage_path('app\public/' . $request->file('file')->store('posts', 'public'));
            $nombre = 'posts/' . basename($ruta);
            Image::make($request->file('file'))->save($ruta);
            $post->imagen = $nombre;
            $post->save();
        }

        //Retornar

        return back()->with('status', 'Creado con Exito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $post = Post::findOrfail($post->id);

        return view('adminposts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $post->update($request->all());

        // if ($request->file('file')) {

        //     Storage::disk('public')->delete($post->image);

        //     $post->image = $request->file('file')->store('posts', 'public');
        //     $post->save();
        // }

        if ($request->file('file')) {

            // Primero Validamos si Existe la Imagen
            // Eliminamos la Imagen
            if($post->image){
                Storage::disk('public')->delete($post->image);
            }

            $ruta = storage_path('app\public/' . $request->file('file')->store('posts', 'public'));

            $nombre = 'posts/' . basename($ruta);

            // con resize le damos un tamaño de 800x400
            Image::make($request->file('file'))->resize(500,300)->save($ruta);

            $post->image = $nombre;

            $post->save();
        }

        // Usamos redirect()->route() para que al actualizar el post nos refresque con el nuevo slug
        return redirect()->route('posts.edit', $post->slug)->with('status', 'Actualizado Con Exito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Eliminamos la Imagen de dicho Post
        Storage::disk('public')->delete($post->image);

        $post->delete();
        return back()->with('status', 'Eliminado Correctamente');
    }
}
