<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\CityStoreRequest;
use App\Http\Requests\Admin\CityUpdateRequest;
use App\Http\Resources\Admin\NewsCollection;
use App\Http\Resources\Admin\NewsResource;
use App\Models\Admin\City;
use App\Models\News;
use http\Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function index(Request $request)
    {
        $news = News::all();
        return response(new NewsCollection($news), 200);
    }

    /**
     * @param \App\Http\Requests\CityStoreRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function store(Request $request)
    {
        $news = News::create([
            'title' => $request['title'],
            'slug' => str_slug($request['title']),
            'image' => $request['image'],
            'content' => $request['content']
        ]);
        return response(null, 200);
    }

    public function uploadImage(Request $request)
    {
        if (!Storage::disk('public')->exists('news')) {
            Storage::disk('public')->makeDirectory('news');
        }

        $imageName = 'news_' . uniqid() . '.jpg';
        $request->file('image')->storeAs('news', $imageName, 'public');
        return response()->json(['image' => $imageName], 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\City $city
     * @return \App\Http\Resources\CityResource|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(News $news)
    {
        $item = json_encode(new NewsResource($news));
        return view('adminPanel.news.show_news', compact('item'));
    }

    public function edit(News $news)
    {
        $item = json_encode(new NewsResource($news));
        return view('adminPanel.news.edit_news', compact('item'));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response
     */
    public function update(Request $request)
    {
        $news = News::find($request->id);

        $news->title = $request->title;
        $news->slug = Str::slug($request->title);
        $news->image = $request->image;
        $news->content = $request['content'];
        $news->save();

        return response()->json(['message' => 'Новость успешно обновлена'], 200);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, News $news)
    {
        News::find($id)->delete();
        // $news->delete();
        return response()->noContent();
    }
}
