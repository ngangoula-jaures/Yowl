<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use shweshi\OpenGraph\Facades\OpenGraphFacade as OpenGraph;
class PostController extends Controller
{
    public function create(Request $request){
        $url= $request->input('url');
        
        try{
            if(str_contains($url, 'youtube.com') || str_contains($url, 'youtu.be')){
                $oembedUrl= 'https://www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';
                $jsondata= file_get_contents($oembedUrl);
                $dataOg= json_decode($jsondata, true);
                $type = $dataOg['type'] ?? 'aucun type';
                $title = $dataOg['author_name'] ?? 'sans titre';
                $image = $dataOg['thumbnail_url'] ?? 'aucune image';
                $description= $dataOg['title'] ?? 'pas de description';
            }else{
            $dataOg= OpenGraph::fetch($url);
            $type = $dataOg['type'] ?? 'aucun type';
            $title = $dataOg['title'] ?? 'sans titre';
            $image = $dataOg['image'] ?? 'aucune image';
            $description= $dataOg['description'] ?? 'pas de description';
            }
            
        }catch(\Exception $e){
            $err= $e->getMessage() . '\n' ;
            return redirect("/")->with('echec', $err);
        }

        if($image === 'aucune image'){
            session()->flash('echec', "Votre lien ne contient pas d'image!\nVeuillez ajouter un image svp!");
        }
        return Inertia::render('Post', [
            'type'=> $type,
            'title'=> $title,
            'image'=> $image,
            'description'=> $description
        ]);
    }
}
