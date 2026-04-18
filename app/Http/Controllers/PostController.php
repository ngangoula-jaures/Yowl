<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use Inertia\Inertia;
use Inertia\Response;
use shweshi\OpenGraph\Facades\OpenGraphFacade as OpenGraph;
class PostController extends Controller
{
    public function create(Request $request){
        $url= $request->input('url');
        $commentaire= $request->input('comment');
    
        if($request->action === 'preview'){
            $request->validate([
                'url' => 'required|unique:posts,url',
                'comment'=> 'required',
                ]);

            try{
                if(str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')){
                    $oembedUrl= 'https://www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
                    $jsondata= file_get_contents($oembedUrl);
                    $dataOg= json_decode($jsondata, true);
                    $type = $dataOg['type'] ?? null;
                    $title = $dataOg['author_name'] ?? null;
                    $image = $dataOg['thumbnail_url'] ?? 'aucune image';
                    $description= $dataOg['title'] ?? null;
            }else{
                $dataOg= OpenGraph::fetch($url);
                $type = $dataOg['type'] ?? null;
                $title = $dataOg['title'] ?? null;
                $image = $dataOg['image'] ?? 'aucune image';
                $description= $dataOg['description'] ?? null;
            }
        }catch(\Exception $e){
            $err= $e->getMessage() . '\n' ;
            session()->flash('echec', "Les données du lien n'ont pas pu etre recuperer! \n ajouter une image! \n" . $err);
            return Inertia::render('Post');
        }

        if($image === 'aucune image'){
            session()->flash('echec', "Votre lien ne contient pas d'image!\nVeuillez ajouter un image svp!");
        }

        session()->put('preview', [
            'image'=> $image,
            'title'=> $title, 
            'type'=> $type, 
            'description'=> $description,
        ]);
        return Inertia::render('Post', [
            'type'=> $type,
            'title'=> $title,
            'image'=> $image,
            'description'=> $description
        ]);
    }else if($request->action === 'save'){
        $user_id = 1;//faire Auth::id()
        $preview = session()->get('preview');
        if($request->img === null){
            $request->validate([
                'url' => 'required|unique:posts,url'
                ]);

            if($preview['title'] && $preview['description'] && $preview['type']){
                Post::create([
                'url'=> $url,
                'user_id' => $user_id,
                'content'=> $commentaire,
                'image'=> $preview['image'], 
                'url_title'=> $preview['title'],
                'url_description'=> $preview['description'], 
                'url_type'=> $preview['type']
                ]);
            }else{
                Post::create([
                'url'=> $url,
                'user_id' => $user_id,
                'content'=> $commentaire,
                'image'=> $preview['image'],
                ]);
            }
        }else{
            $request->validate([
                'img' => 'required|image|mimes:jpg,png,jpeg,webp,avif,gif,svg|max:2000',
                ]);
            $image = $request->file('img')->store('images', 'public');
            Post::create([
            'url'=> $url,
            'user_id' => $user_id,
            'content'=> $commentaire,
            'image'=> $image,
            ]);
        }
        session()->forget('preview');
        session()->flash('success', 'Post créé avec succès !');
        return redirect()->route('post');
    }   
}

}
