<?php

namespace App\Http\Controllers;

use App\Post;
use App\UserAchievement;
use DB;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        DB::beginTransaction();
        try {
            $data = request()->validate([
                'caption' => 'required',
                'image' => ['required', 'image'],
            ]);

            $imagePath = request('image')->store('uploads', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
            $image->save();

            auth()->user()->posts()->create([
                'caption' => $data['caption'],
                'image' => $imagePath,
            ]);

            UserAchievement::trackUserPost(auth()->user()->id);

            DB::commit();
            return redirect('/profile/' . auth()->user()->id);
        } catch (\Throwable $th) {
            DB::rollBack();
             return redirect('/profile/' . auth()->user()->id)->with([
                'message'=> $th->getMessage(),
                'status' => 'error'
             ]);
        }
    }

    public function show(\App\Post $post)
    {
        $userId = $post->user->id;
        $follows = (auth()->user()) ? auth()->user()->following->contains($userId) : false;

        return view('posts.show', [
            'post' => $post,
            'userId' => $userId,
            'follows' => $follows
        ]);
    }
    public function destroy(\App\Post $post)
    {
        try {
            $post->delete();
            return redirect(route('profile.show', ['user' => auth()->user()->id]))->with([
                'message' => 'Post has been deleted successfully',
                'status' => 'success'
            ]);
        } catch (\Throwable $th) {
            return redirect(route('profile.show', ['user' => auth()->user()->id]))->with([
                'message' => 'Post is not deleted successfully',
                'status' => 'error'
            ]);
        }
    }
}

