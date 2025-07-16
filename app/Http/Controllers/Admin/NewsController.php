<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!$request->session()->get('clientUser')) {
                // User is not authenticated, perform logout
                return redirect()->route('admin_login')->with('error', 'Please log in to the system again.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'News List';
        $condition = [];
        $newsList = News::listNews($condition, \Config::get('constants.admin_pagination'));
        return view('admin.news.index', compact('title', 'newsList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create News';
        return view('admin.news.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestArr = $request->all();
        $insertId = News::storeNews($requestArr);
        return redirect(route('news'))->with('success', 'Create!!!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = 'Edit News';

        $condition = [['id',$id]];
        $news = News::getNews($condition);
        return view('admin.news.edit', compact('title', 'news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $requestArr = $request->all();
        $insertId = News::updateNews($requestArr);
        return redirect(route('news'))->with('success', 'Update Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        News::deleteNews($id);
        return redirect(route('news'))->with('success', 'Disabled Successfully!!!');
    }

    /**
     * Show the form for import resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $title = 'Import News';
        return view('admin.news.import', compact('title'));
    }

    /**
     * Store a newly import resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importSuccess(Request $request)
    {
        $requestArr = $request->all();

        $yesterday_date = date("Y-m-d",strtotime("-1 days"));
        $count = News::where('published_at','like', "%".$yesterday_date."%")->count();
        $agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';
        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL,'https://newsapi.org/v2/everything?q=Apple&from='.$yesterday_date.'&sortBy=popularity&apiKey=cfabf3eee7f24ae197c0347475603bd4&page=1');
        curl_setopt($curl_handle, CURLOPT_USERAGENT, $agent);
        curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,2);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1);
        $buffer = curl_exec($curl_handle);
        $bufferArr = json_decode($buffer);

        $status = $bufferArr->status;
        $totalCount = (int)ceil($bufferArr->totalResults/100);
        $articles = $bufferArr->articles;

        $msg = 'News already imported';
        $type = 'error';

        if($status == 'ok' && $count == 0) {
            for ($page = 1; $page <= $totalCount; $page++) {
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, 'https://newsapi.org/v2/everything?q=Apple&from=' . $yesterday_date . '&sortBy=popularity&apiKey=cfabf3eee7f24ae197c0347475603bd4&page=' . $page);
                curl_setopt($curl_handle, CURLOPT_USERAGENT, $agent);
                curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
                $buffer = curl_exec($curl_handle);
                $bufferArr = json_decode($buffer);
                $totalCount = (int)ceil($bufferArr->totalResults / 100);
                $request = [];

                foreach ($articles as $article) {
                    $source_id = strip_tags(htmlspecialchars_decode($article->source->id));
                    $source_name = strip_tags(htmlspecialchars_decode($article->source->name));
                    $author = strip_tags(htmlspecialchars_decode($article->author));
                    $title = strip_tags(htmlspecialchars_decode($article->title));
                    $description = strip_tags(htmlspecialchars_decode($article->description));
                    $content = strip_tags(htmlspecialchars_decode($article->content));
                    $url = strip_tags(htmlspecialchars_decode($article->url));
                    $urlToImage = strip_tags(htmlspecialchars_decode($article->urlToImage));
                    $publishedAt = strip_tags(htmlspecialchars_decode($article->publishedAt));
                    $cleanDate = trim(explode(' ', $publishedAt)[0]); // '2025-07-15T04:15:00Z'
                    $formattedDate = Carbon::parse($cleanDate)->format('Y-m-d');


                    $request['source_id'] = $source_id;
                    $request['source_name'] = $source_name;
                    $request['author'] = $author;
                    $request['title'] = $title;
                    $request['description'] = $description;
                    $request['content'] = $content;
                    $request['url'] = $url;
                    $request['url_image'] = $urlToImage;
                    $request['published_at'] = $formattedDate;
                    $request["status"] = 'Enabled';
                    $request['client_user_id'] = $requestArr['client_user_id'];

                    $insertId = News::storeNews($request);
                    echo $insertId . ", ";
                }

                sleep(2);
            }
            $msg = 'News import Successfully';
            $type = 'success';
        } else {
            $msg = 'News already imported';
            $type = 'error';
        }

        return redirect(route('news'))->with($type, $msg);
    }
}
