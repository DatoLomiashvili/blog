<?php

namespace App\Http\Controllers\Backend;


use App\Models\Blog;
use App\Models\Comment;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BlogsController extends Controller
{

    protected $query;
    protected $validationArray = [];

    /**
     * @throws Exception
     */
    public function __construct(Blog $blog)
    {
        parent::__construct();
        $this->data['list'] = $blog->getList();
    }

    /**
     * @param $id
     * @param Blog $blog
     * @return View|Factory|Application
     */
    public function view($id, Blog $blog): View|Factory|Application
    {
        $this->data['row'] = $blog->getBlogById($id);
        $this->data['id'] = $id;
        $this->data['userId'] = Auth::user() ? Auth::user()['id'] : null;
        $this->data['role'] = Auth::user()? Auth::user()['role'] : null;

        return view('blog_inside', $this->data);
    }
}
