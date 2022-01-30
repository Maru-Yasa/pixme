<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pages;
use App\Models\User;
use App\Models\Comments;
use App\Models\PageViews;
use App\Models\SubComments;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Page extends Controller
{
    public function index($username,Request $req)
    {

        $user = User::all()->where('username',"=",$username)->first();

        if (is_null($user)) {
            return view('errors.404');
        }

        $userId = $user->id;
        $page = Pages::find($userId);

        $this->addVisitor($req,$userId);
        $this->countVisitors($page->id);
        $this->countComments($page->id,$userId);
        
        $comments = Comments::all()->where('owner','=',$userId)->sortByDesc('created_at');
        $sub_comments = SubComments::all()->where('owner','=',$userId)->toArray();

        $commentsArray = [];
        $sub_commentsArray = $sub_comments;

        foreach ($comments as $el) {

            $commentsArray[] = [
                'id' => $el->id,
                'owner' => $el->owner,
                'comment' => $el->comment,
                'created_at' => $el->created_at,
                'sub_comments' => []
            ];

        }

        for ($i=0; $i < count($commentsArray); $i++) { 
            $commentsArray[$i]['sub_comments'] = [];
        }


        for ($i=0; $i < count($commentsArray); $i++) { 
            $items = [];
            $comment_id = $commentsArray[$i]['id'];
            for ($j=0; $j < count($sub_commentsArray); $j++) { 
                $sub_comment_id = $sub_commentsArray[$j]['parent_comment'];
                if ($comment_id === $sub_comment_id) {
                    $items[] = [
                        'id' => $sub_comment_id,
                        'owner' => User::find($userId)->first()->username,
                        'comment' => $sub_commentsArray[$j]['comment']
                    ]; 
                    $commentsArray[$i]['sub_comments'] = $items;
                }
            }
        }

        $comments = $this->paginate($commentsArray,5);
        $comments->withPath('/u/'.$user->username);


        $data = array(

            "page" => [
                "id" => $page->id,
                "owner" => $page->owner,
                "visitors" => $page->visitors,
                "comments_count" => $page->comments_count,
                "desc" => $page->desc
            ],
            "user" => [
                "id" => $userId,
                "username" => $user->username
            ],
            "comments" => $comments

        );
        return view('page',["data" => $data]);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function sendComment(Request $req)
    {
        $userId = $req->user_id;
        $username = User::find($userId)->username;
        $comment_text = $req->comment_text;

        $newComment = new Comments();
        $newComment->owner = $userId;
        $newComment->comment = $comment_text;
        if ($newComment->save()) {
            return redirect('/u/'.$username)->with('msg','sended!');
        }else{
            return redirect('/u/'.$username)->with('msg_error','failed to send comment');
        }

    }

    private function countVisitors($pageId)
    {
        $visitors = PageViews::all()->where('page','=',$pageId)->count();
        $page = Pages::find($pageId);
        $page->visitors = $visitors;
        $page->save();
    }

    private function countComments($pageId,$userId)
    {
        $comments_count = Comments::all()->where('owner','=',$userId)->count();
        $page = Pages::find($pageId);
        $page->comments_count = $comments_count;
        $page->save();
    }


    private function addVisitor(Request $req, $userId)
    {
        $ip = $req->ip();
        $pageId = Pages::all()->where('owner','=',$userId)->first()->id;
        $checkUnique = PageViews::all()->where('page','=',$pageId)->where('ip','=',$ip)->first();

        $visitors = PageViews::all()->where('page','=',$pageId)->count();
        $page = Pages::find($pageId);
        $page->visitors = $visitors;
        $page->save();

        if (is_null($checkUnique)) {
            PageViews::create([
                "ip" => $ip,
                "page" => $pageId
            ]);
        }

    }

}
