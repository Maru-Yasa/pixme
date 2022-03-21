<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pages;
use App\Models\User;
use App\Models\Comments;
use App\Models\SubComments;
use App\Models\PageViews;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class Profile extends Controller
{
    public function index(Request $req)
    {
        $userId = Auth::id();
        $user = User::all()->where('id',$userId)->first();
        $page = Pages::find($userId);
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

            foreach($sub_commentsArray as $key => $sc){  
                if($comment_id === $sc['parent_comment']){
                    $items[] = [
                        'id' => $key,
                        'owner' => $user->username,
                        'comment' => $sc['comment']
                    ]; 
                    $commentsArray[$i]['sub_comments'] = $items;                   
                }
            }

            // bug dikarenakan $sub_commentArray's index tidak dimulai dari index 0 namun index = id
            // maka for digandi dengan foreach
            // for ($j=0; $j < count($sub_commentsArray); $j++) {
            //     if (isset($sub_commentsArray[$j])) {
            //         $sub_comment_id = $sub_commentsArray[$j]['parent_comment'];
            //         if ($comment_id === $sub_comment_id) {
            //             $items[] = [
            //                 'id' => $sub_comment_id,
            //                 'owner' => User::find($userId)->first()->username,
            //                 'comment' => $sub_commentsArray[$j]['comment']
            //             ]; 
            //             $commentsArray[$i]['sub_comments'] = $items;
            //         }
            //      } 
            // }
        }

        $comments = $this->paginate($commentsArray,5);
        $comments->withPath('/profile');


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
        return view('profile',["data" => $data]);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function logout(Request $req)
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

    public function editProfileView(Request $req)
    {
        $userId = Auth::id();
        $user = User::find($userId);
        $page = Pages::find($userId);

        return view('editprofile',['user'=>$user,'page'=>$page]);

    }

    public function editGeneralProfile(Request $req)
    {

        if (is_null($req->password)) { 
            $regex = '/[\'\/~`\!@#\$%\^&\*\(\)-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
            $id = Auth::id();

            $validator = $req->validate([
                'username'  => ['required',"not_regex:".$regex,'min:4','max:12','unique:users,username' . ($id ? ",$id" : '')],
            ]);

            User::where('id', $id)->update([
                'username' => $validator['username']
            ]);

            return redirect('/editprofile')->with('msg_profile','Success edit profile');

        }else{
            $regex = '/[\'\/~`\!@#\$%\^&\*\(\)-\+=\{\}\[\]\|;:"\<\>,\.\?\\\]/';
            $id = Auth::id();

            $validator = $req->validate([
                'username'  => ['required',"not_regex:".$regex,'min:4','max:12','unique:users,username' . ($id ? ",$id" : '')],
                'password'  => ['required','min:6']
            ]);

            User::where('id', $id)->update([
                'username' => $validator['username'],
                'password' => Hash::make($validator['password'])
            ]);

            return redirect('/editprofile')->with('msg_profile','Success edit profile');
        }
    }

    public function editPage(Request $req)
    {
        $userId = Auth::id();
        $desc = $req->desc;
        $page = Pages::all()->where('owner',$userId)->first();

        $page->desc = $desc;
        if ($page->save()) {
            return redirect('/editprofile#page')->with('msg_page',"success update page's desc");
        }else{
            return redirect('/editprofile#page')->withErr('msg_page_error',"somethins went wrong");
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

    public function sendSubComment(Request $req)
    {
        $newSub = new SubComments();
        $newSub->owner = Auth::id();
        $newSub->parent_comment = $req->commentId;
        $newSub->comment = $req->reply_text;
        $newSub->save();
        return redirect('/profile#'.$req->commentId);
    }


    public function deleteComment($id,Request $req)
    {   
        Comments::all()->where('id','=',$id)->where('owner','=',Auth::id())->firstOrFail()->forceDelete();
        return redirect('/profile');            

    }


}
