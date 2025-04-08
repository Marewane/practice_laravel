<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsController extends Controller
{
    //
    public function getPosts(Request $request){
        // $query = 'select * from posts';
        // $posts = DB::select($query);
        $posts = DB::table('posts')->paginate(2);
        return view('posts',[
            'postsData'=>$posts
        ]);
    }


    public function redirectToCreatePost(Request $request){
        return view('addPost');
    }

    public function createPost(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');

        // $query = 'insert into posts(title,content,created_at,updated_at)
        // values(:title,:content,:created_at,:updated_at)
        // ';
        // DB::insert($query,[
        //     'title'=>$title,
        //     'content'=>$content,
        //     'created_at'=>NOW(),
        //     'updated_at'=>NOW()
        // ]);
        DB::table('posts')->insert([
            'title' => $title,
            'content' => $content,
            'created_at' => NOW(),
            'updated_at' => NOW()
        ]);

        return redirect()->route('getPosts')->with('success','Post created successfully');
    }

    public function editPost(Request $request , $id){
        // $query = 'select * from posts where id=:id';
        // $post = DB::select($query,[
        //     'id' => $id
        // ]);
        $post = DB::table('posts')->where('id',$id)->get();

        return view('editPost' ,['post'=> $post[0]]);
    }

    public function updatePost(Request $request,$id){
        $updatedTitle = $request->input('title');
        $updatedContent = $request->input('content');

        // $query = 'update  posts set title = :title , content=:content , updated_at=:updated_at where id=:id';
        // $updatedPost = DB::update($query,[
        //     'title'=>$updatedTitle,
        //     'content'=>$updatedContent,
        //     'updated_at'=>NOW(),
        //     'id' => $id
            
        // ]);

        $updatedPost = DB::table('posts')->where('id',$id)->update([
            'title'=>$updatedTitle,
            'content'=>$updatedContent,
            'updated_at'=>NOW(),
            'id' => $id
        ]);

        return redirect()->route('getPosts')->with('success','Post Updated successfully');
        
        
    }

    public function deletePost(Request $request,$id){
        // $query = 'delete from posts where id=:id';
        // DB::delete($query,[
        //     'id'=>$id
        // ]);

        DB::table('posts')->delete($id);
        return redirect()->route('getPosts')->with('success','Post has been deleted successuflly');
    }

    public function searchPosts(Request $request){
        $title = $request->input('title');
        $posts = DB::table('posts')
                    ->where('title', 'LIKE', '%' . $title . '%')
                    ->get();
    
        return view('posts', [
            'searchedPosts' => $posts
        ]);
    }

    public function deleteAllPosts(Request $request){
        DB::table('posts')->delete();
        return redirect()->route('getPosts')->with('success','all posts has been deleted');
    }


    public function deleteAllPostsWithBackUp(Request $request){
        try {
            DB::transaction(function () {
                // Step 1: Create the backup table (only once)
                DB::statement('CREATE TABLE IF NOT EXISTS backup_posts LIKE posts');
    
                // Step 2: Backup data
                DB::table('backup_posts')->insertUsing(
                    ['id', 'title', 'content', 'created_at', 'updated_at'],
                    DB::table('posts')->select('id', 'title', 'content', 'created_at', 'updated_at')
                );
    
                // Step 3: Delete data
                DB::table('posts')->delete();
            });
    
            return redirect()->route('getPosts')->with('success','All posts deleted and backed up successfully');
    
        } catch (\Exception $e) {
            return back()->with('error', 'Error during transaction: ' . $e->getMessage());
        }
    }
    
    public function restorePosts(Request $request){
        DB::transaction(function(){
            DB::table('posts')->insertUsing([
                    'id','title','content','created_at','updated_at'
                ],
                DB::table('backup_posts')->select('id','title','content','created_at','updated_at')
            ); 
            DB::table('backup_posts')->delete();     
        });

        // return view('posts',[
        //     'success' => 'posts restore has been successufly restored'
        // ]);
        return redirect()->route('getPosts');
        
        
    }
}
