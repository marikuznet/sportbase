<?php

namespace App\Http\Controllers;

use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use League\Event\Event;

class NewsController extends Controller
{
    public function index(Request $request){
        $news = News::paginate($request->total);;
        return new NewsCollection($news);
    }

    public function show(News $newses){
        $newses->increment('view_count');
        $news = json_encode(new NewsResource($newses));
        return view('viewNews', compact('news'));
    }

    public function showImage($name){
        try {
            $file = Storage::disk('local')->get("public/news/$name");
            return (new Response($file, 200))
                ->header('Content-Type', 'image/jpeg, image/jpg');
        } catch (Exception $e) {
            return "/images/common/icons/general/content-loader.gif";
        } catch (FileNotFoundException $e) {
            return $e;
        }
    }
}
