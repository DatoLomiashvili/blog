<?php

namespace App\Http\Controllers\Backend;


use App\Models\Blog;
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
        $this->templateName .= "blogs";
        $this->pagerLimit = 2;
        $this->data['list'] = $blog->getList();
	}

    /**
     * @param Blog $blog
     * @return View|Factory|Application
     * @throws AuthorizationException
     */
	public function view(Blog $blog): View|Factory|Application
    {
        $this->authorize('view', $blog);
		$this->data['list'] = $blog->getList();

		return view($this->templateName, $this->data);
	}

    /**
     * @param $id
     * @param Blog $blog
     * @return \Illuminate\Foundation\Application|View|Factory|Application
     * @throws AuthorizationException
     */
	public function edit($id, Blog $blog): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $this->data['row'] = $blog->getBlogById($id);
        $this->authorize('update', $this->data['row']);
        $this->templateName .= __FUNCTION__;

		return view($this->templateName, $this->data);
	}

    /**
     * @param $id
     * @param Request $request
     * @param Blog $blog
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
	public function update($id, Request $request, Blog $blog): RedirectResponse
    {
        $this->authorize('update', $blog);

        $this->validate($request, $this->validationArray);

		$blog->getBlogById($id)
			->update([
				'title' => $request->title,
			]);
		return redirect()->back();
	}

    /**
     * @param $id
     * @param Blog $blog
     * @return RedirectResponse
     * @throws AuthorizationException
     */
	public function delete($id, Blog $blog): RedirectResponse
    {
        $this->authorize('delete', $blog);

        $blog->getBlogById($id)
            ->delete();

        return redirect()->back();
	}
}
