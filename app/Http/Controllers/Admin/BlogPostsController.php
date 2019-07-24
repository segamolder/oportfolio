<?php
/**
 * Created by PhpStorm.
 * User: molde
 * Date: 05.06.2019
 * Time: 19:13
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Date;
use mysql_xdevapi\Exception;

class BlogPostsController extends Controller
{
    public function SaveNewPost(Request $request)
    {
        $dataR = $request->getContent();
        $requestArray = json_decode($dataR, true);
        $post = new BlogPost();

        $dom = new \DOMDocument();
        $dom->loadHtml($requestArray['postData'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        //
        $dom = $this->postSummernote($dom);
        //
        $images = $dom->getElementsByTagName('img');
        if ($images->length != 0) {
            $src = $images->item(0)->getAttribute('src');
            $post->img = $src;
        } else {
            $post->img = "";
        }
        $post->blog_data = $dom->saveHTML();
        $post->text = $requestArray['text'];
        $post->title = $requestArray['title'];
        $post->isActive = false;
        $post->category = $requestArray['category'];
        try {
            $post->save();
        } catch (\Exception $ex) {
            throw new Exception("Не удалось сохранить");
        }
        return "OK";
    }

    public function GetAll()
    {
        $blogPost = new BlogPost();
        return json_encode($blogPost->all());
    }

    public function EditPostView($id)
    {
        return view('admin/home', ['id' => $id]);
    }

    public function GetPost($id)
    {
        $blogPost = BlogPost::where('id', $id)->get();
        return json_encode($blogPost);
    }

    public function EditPost(Request $request)
    {
        $blogPost = $request->all();

        $dom = new \DOMDocument();
        @$dom->loadHtml('<?xml encoding="utf-8" ?>' . $blogPost['postData'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        //
        $dom = $this->postSummernote($dom);
        //
        $images = $dom->getElementsByTagName('img');
        if ($images->length != 0) {
            $src = $images->item(0)->getAttribute('src');
            $img = $src;
        } else {
            $img = "";
        }
        $test = $dom->saveHTML();
        BlogPost::where('id', $blogPost['id'])->update([
            'title' => $blogPost['title'],
            'text' => $blogPost['text'],
            'blog_data' => $dom->saveHTML(),
            'isActive' => false,
            'category' => $blogPost['category'],
            'img' => $img
        ]);
        return 'Ok';
    }

    public function SetToggle(Request $request)
    {
        try {
            $data = $request->all();

            BlogPost::where('id', $data['id'])->update([
                'isActive' => $data['isActive']
            ]);

            return 'Ok';
        } catch (\Exception $ex) {
            return $ex;
        }
    }

    public function postSummernote($dom)
    {
        $images = $dom->getElementsByTagName('img');

        foreach ($images as $k => $img) {

            $data = $img->getAttribute('src');
            if (strpos($data, 'data')) {
                list($type, $data) = explode(';', $data);

                list(, $data) = explode(',', $data);

                $data = base64_decode($data);

                $image_name = "/upload/" . time() . $k . '.png';

                $path = public_path() . $image_name;

                file_put_contents($path, $data);

                $img->removeAttribute('src');

                $img->setAttribute('src', $image_name);
            }

        }

        $detail = $dom->saveHTML();

        return $dom;

    }

    public function GetPostById($id) {
        return view('blogPostView', ['id' => $id]);
    }
}
