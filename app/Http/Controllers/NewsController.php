<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    /**
     * @param Request $request
     * @return Factory|View|Application
     */
    public function index(Request $request): Factory|View|Application
    {
        $popularPost = Post::where(['status' => 1, 'is_popular' => 1])->first();

        $posts = Post::where([
            'status' => 1
        ])
            ->when($popularPost, function ($query) use ($popularPost) {
                $query->where('id', '!=', $popularPost->id);
            })
            ->paginate($request->input('per_page', 12));

        return view('pages.news.index', [
            'posts' => $posts,
            'popularPost' => $popularPost
        ]);
    }

    /**
     * @param Request $request
     * @param string $locale
     * @param string $slug
     * @return Factory|View|Application
     */
    public function show(Request $request, string $locale, string $slug): Factory|View|Application
    {
        $post = Post::where(['status' => 1, 'slug' => $slug])->first();

        abort_if(!$post, Response::HTTP_NOT_FOUND);

        $recentPosts = Post::where([
            'status' => 1
        ])
            ->when($post, function ($query) use ($post) {
                $query->where('id', '!=', $post->id);
            })
            ->limit(10)
            ->get();

        return view('pages.news.show', [
            'post' => $post,
            'recentPosts' => $recentPosts
        ]);
    }
}
