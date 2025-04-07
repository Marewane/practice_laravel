<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    //
    public function getPosts(Request $request){
        $query = 'select * from posts';
        $posts = DB::select($query);
        return view('posts',[
            'data'=>$posts
        ]);
    }


    public function redirectToCreatePost(Request $request){
        return view('addPost');
    }

    public function createPost(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');

        $query = 'insert into posts(title,content,created_at,updated_at)
        values(:title,:content,:created_at,:updated_at)
        ';
        DB::insert($query,[
            'title'=>$title,
            'content'=>$content,
            'created_at'=>NOW(),
            'updated_at'=>NOW()
        ]);

        return redirect()->route('getPosts')->with('success','Post created successfully');
    }

    public function editPost(Request $request , $id){
        $query = 'select * from posts where id=:id';
        $post = DB::select($query,[
            'id' => $id
        ]);

        return view('editPost' ,['post'=> $post[0]]);
    }

    public function updatePost(Request $request,$id){
        $updatedTitle = $request->input('title');
        $updatedContent = $request->input('content');

        $query = 'update  posts set title = :title , content=:content , updated_at=:updated_at where id=:id';
        $updatedPost = DB::update($query,[
            'title'=>$updatedTitle,
            'content'=>$updatedContent,
            'updated_at'=>NOW(),
            'id' => $id
            
        ]);

        return redirect()->route('getPosts')->with('success','Post Updated successfully');
        
        
    }

    public function deletePost(Request $request,$id){
        $query = 'delete from posts where id=:id';
        DB::delete($query,[
            'id'=>$id
        ]);
        return redirect()->route('getPosts')->with('success','Post has been deleted successuflly');
    }
}
