<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;
use Symfony\Component\DomCrawler\Crawler;

class CrawlController extends Controller
{
    /**
     * 抓取網頁資料
     * @param Request $request
     */
    public function crawl(Request $request)
    {
        $pathToImage = Str::random() . '.png';
        $response = Http::get($request->input('url'));
//        取得 screenshot 失敗
//        Browsershot::url($request->input('url'))
//            ->save($pathToImage);


        $crawler = new Crawler($response->body());
        $title = $crawler
            ->filter('head > title')
            ->text();
        $description = $crawler
            ->filter('head > meta[name=description]')
            ->attr('content');
        $body = $crawler
            ->filter('body')
            ->html();

        $page = new Page();
        $page->screenshot = $pathToImage;
        $page->title = $title;
        $page->url = $request->input('url');
        $page->description = $description;
        $page->body = $body;
        $page->save();
        return redirect('/crawled-page');
    }

    /**
     * 列出所有抓取網頁資料
     */
    public function index()
    {
        $pages = Page::all();
        return view('crawled-index', ['pages' => $pages]);
    }

    /**
     * 列出單一抓取網頁資料大概內容
     * @param Request $request
     * @param string $id
     * @return View
     */
    public function show(Request $request, string $id): View
    {
        $page = Page::find($id);
        return view('crawled-show', ['page' => $page]);
    }
}
