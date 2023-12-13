<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Services\Base64Services;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $generateResponse;
    protected $base64Services;
    public function __construct(GenerateResponse $generateResponse, Base64Services $base64Services)
    {
        $this->generateResponse = $generateResponse;
        $this->base64Services = $base64Services;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $queryTitle = request()->query('title');
            $querySlug = request()->query('slug');
            $queryTypePost = request()->query('type_post');
            $queryCategory = request()->query('category');
            $queryStatus = request()->query('status');
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;

            $post = Post::query();
            if ($queryTitle)
                $post->where('title', 'like', '%' . $queryTitle . '%');
            if ($querySlug)
                $post->where('slug', 'like', '%' . $querySlug . '%');
            if ($queryTypePost)
                $post->where('type_post_id', $queryTypePost);
            if ($queryCategory)
                $post->where('category_id', $queryCategory);
            if ($queryStatus)
                $post->where('status_id', $queryStatus);
            $post->orderBy('created_at', 'desc');
            $post->with(['typePost', 'category', 'status', 'postedBy']);
            $totalData = $post->count();
            $offset = ($queryPage - 1) * $queryLimit;
            $post->offset($offset);
            $post->limit($queryLimit);
            $data = $post->get();
            $totalPage = ceil($totalData / $queryLimit);
            $currentPage = $queryPage;
            $prevPage = $queryPage - 1 ? $queryPage - 1 : null;
            $nextPage = $currentPage < $totalPage ? $currentPage + 1 : null;
            $pagination = [
                'total_data' => (int)$totalData,
                'total_page' => (int)$totalPage,
                'current_page' => (int)$currentPage,
                'prev_page' => (int)$prevPage,
                'next_page' => (int)$nextPage,
            ];
            return $this->generateResponse->response200([
                'posts' => $data,
                'page' => $pagination
            ], 'Berhasil');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if (!$request->user() || !User::find($request->user()->id))
                return $this->generateResponse->response401();
            $rules = [
                'title' => 'required|string',
                'content' => 'required|string',
                'image' => 'required|string',
                'type_post_id' => 'required|exists:generic_codes,generic_code_id',
                'category_id' => 'required|exists:generic_codes,generic_code_id',
                'status_id' => 'required|exists:generic_codes,generic_code_id',
                // 'posted_by' => 'required|exists:users,id',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails())
                return $this->generateResponse->response400('Bad Request', $validator->errors());
            // check if user is exist

            // validate image
            if (!$this->base64Services->validateBase64($request->image))
                return $this->generateResponse->response400('Bad Request', 'Image is not valid');
            // validate max size image 500kB
            if ($this->base64Services->base64Size($request->image) > 500)
                return $this->generateResponse->response400('Bad Request', 'Image is too large');

            $image = $this->base64Services->uploadImage($this->base64Services->base64StringOnly($request->image), '/images/posts/');
            $post = new Post();
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->content = $request->content;
            $post->image = $image->file_name;
            $post->image_url = $image->file_url;
            $post->type_post_id = $request->type_post_id;
            $post->category_id = $request->category_id;
            $post->status_id = $request->status_id;
            $post->posted_by = $request->user()->id;
            $post->save();
            return $this->generateResponse->response201($post, 'Berhasil ditambahkan');
        } catch (\Throwable $th) {
            if ($image) $this->base64Services->deleteFileContent($image->file_path);
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $post = Post::where('id', $id)
                ->with(['typePost', 'category', 'status', 'postedBy'])
                ->first();
            if (!$post)
                return $this->generateResponse->response404();

            // update view count
            $post->view_count = $post->view_count + 1;
            $post->save();

            return $this->generateResponse->response200($post, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if (!request()->user() || !User::find(request()->user()->id))
                return $this->generateResponse->response401();
            $rules = [
                'title' => 'required|string',
                'content' => 'required|string',
                'type_post_id' => 'required|exists:generic_codes,generic_code_id',
                'category_id' => 'required|exists:generic_codes,generic_code_id',
                'status_id' => 'required|exists:generic_codes,generic_code_id',
                // 'posted_by' => 'required|exists:users,id',
            ];
            $validator = validator($request->all(), $rules);
            if ($validator->fails())
                return $this->generateResponse->response400('Invalid Data', $validator->errors());
            // check if user is exist
            $post = Post::find($id);
            if (!$post)
                return $this->generateResponse->response404();
            $user = User::find(request()->user()->id);
            if (!$user)
                return $this->generateResponse->response404('User not found');
            // validate image\
            if ($request->image) {
                if (!$this->base64Services->validateBase64($request->image))
                    return $this->generateResponse->response400('Bad Request', 'Image is not valid');
                // validate max size image 500kB
                if ($this->base64Services->base64Size($request->image) > 500)
                    return $this->generateResponse->response400('Bad Request', 'Image is too large');
                $image = $this->base64Services->uploadImage($this->base64Services->base64StringOnly($request->image), '/images/posts/');
                $post->image = $image->file_name;
                $post->image_url = $image->file_url;
            }
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->content = $request->content;
            $post->type_post_id = $request->type_post_id;
            $post->category_id = $request->category_id;
            $post->status_id = $request->status_id;
            $post->updated_by = $user->id;
            $post->save();
            return $this->generateResponse->response200($post, 'Berhasil diupdate');
        } catch (\Throwable $th) {
            if ($image) $this->base64Services->deleteFileContent($image->file_path);
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            $post = Post::find($id);
            if (!$post)
                return $this->generateResponse->response404();
            $user = User::find($request->user()->id);
            if (!$user)
                return $this->generateResponse->response403();
            $post->deleted_by = $user->id;
            $post->save();
            $post->delete();
            return $this->generateResponse->response200($post, 'Berhasil dihapus');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function read(string $slug)
    {
        try {
            $post = Post::where('slug', $slug)
                ->with(['typePost', 'category', 'status', 'postedBy'])
                ->first();
            if (!$post)
                return $this->generateResponse->response404();

            if (!auth()->user()) {
                $post->view_count = $post->view_count + 1;
                $post->save();
            }
            return $this->generateResponse->response200($post, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function publish(Request $request, $id)
    {
        try {
            $post = Post::find($id);
            if (!$post)
                return $this->generateResponse->response404();
            $user = User::find($request->user()->id);
            if (!$user)
                return $this->generateResponse->response403();
            $post->status_id = '003^002';
            $post->save();
            return $this->generateResponse->response200($post, 'Berhasil dipublish');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function statistic()
    {
        try {
            $post = Post::query();
            $post->selectRaw('count(*) as total, status_id');
            $post->groupBy('status_id');
            $post->with(['status']);
            $data = $post->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function statisticByCategory()
    {
        try {
            $post = Post::query();
            $post->selectRaw('count(*) as total, category_id');
            $post->groupBy('category_id');
            $post->with(['category']);
            $data = $post->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function statisticByMonthYear()
    {
        try {
            $queryMonth = request()->query('month') ? request()->query('month') : date('m');
            $queryYear = request()->query('year') ? request()->query('year') : date('Y');
            $post = Post::query();
            $post->selectRaw('count(*) as total, EXTRACT(MONTH FROM created_at) as month, EXTRACT(YEAR FROM created_at) as year');
            $post->whereRaw('EXTRACT(MONTH FROM created_at) = ' . $queryMonth);
            $post->whereRaw('EXTRACT(YEAR FROM created_at) = ' . $queryYear);
            $post->groupBy('month', 'year');
            $data = $post->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function statisticTotalByDateRange()
    {
        try {
            // if start date is empty set to 1st day of current month
            $queryStartDate = request()->query('start_date') ? request()->query('start_date') : date('Y-m-01');
            // if end date is empty set to current date
            $queryEndDate = request()->query('end_date') ? request()->query('end_date') : date('Y-m-d');
            $post = Post::query();
            $post->selectRaw('count(*) as total, category_id');
            $post->whereBetween('created_at', [$queryStartDate, $queryEndDate]);
            $post->groupBy('category_id');
            $data = $post->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function mostViewed()
    {
        try {
            $queryLimit = request()->query('limit') ? request()->query('limit') : 5;
            $post = Post::query();
            $post->orderBy('view_count', 'desc');
            $post->limit($queryLimit);
            $post->with(['typePost', 'category', 'status', 'postedBy']);
            $data = $post->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
