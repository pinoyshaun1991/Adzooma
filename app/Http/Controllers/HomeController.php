<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Gets the feed from URL
     */
    public function getFeed()
    {
        if (empty($_POST['value'])) {
            return array('code' => 402, 'message' => 'Feed URL is required');
        }

        $data = array();

        try {
            $data = $this->getContents($_POST['value']);
        } catch (Exception $e) {
            print ($e->getMessage());
        }
        $exists = DB::table('feeds')->where('url', $_POST['value'])->first();

        if (empty($exists)) {
            DB::table('feeds')->insert(
                ['url' => $_POST['value']]
            );
        }

        return array('code' => 200, 'message' => $data);
    }

    private function getContents($url)
    {
        if (@simplexml_load_file($url)) {
            $feeds = simplexml_load_file($url);
        } else {
            throw Exception('Feed URL is invalid');
        }

        $data = array();

        if (!empty($feeds)) {
            foreach ($feeds->channel as $item) {
                $data['image']       = $item->image;
                $data['description'] = $item->description;
                $data['link']        = $item->link;
            }
        } else {
            throw Exception('Feed URL is invalid');
        }

        return $data;
    }
}
