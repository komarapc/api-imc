<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            if (!request()->user() || !User::find(request()->user()->id))
                return $this->generateResponse->response401();

            $queryEmail = request()->query('email');
            $queryName = request()->query('name');
            $queryPhone = request()->query('phone');
            $queryPesan = request()->query('content');
            $queryStatusCode = request()->query('status');
            $queryStartDate = request()->query('start_date');
            $queryEndDate = request()->query('end_date');
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;
            $queryResult = ContactMessage::query();
            if ($queryEmail) $queryResult->where('email', 'like', '%' . $queryEmail . '%');
            if ($queryPesan) $queryResult->where('message', 'like', '%' . $queryPesan . '%');
            if ($queryName) $queryResult->where('full_name', 'like', '%' . $queryName . '%');
            if ($queryPhone) $queryResult->where('phone_number', 'like', '%' . $queryPhone . '%');
            if ($queryStatusCode) $queryResult->where('status_code', $queryStatusCode);
            if ($queryStartDate) $queryResult->whereDate('created_at', '>=', $queryStartDate);
            if ($queryEndDate) $queryResult->whereDate('created_at', '<=', $queryEndDate);
            $queryResult->orderBy('created_at', 'desc');
            // total data
            $totalData = $queryResult->count();
            // total data after filtered
            $totalPage = ceil($totalData / $queryLimit);
            $queryResult->skip(($queryPage - 1) * $queryLimit)->take($queryLimit);
            $contactMessages = $queryResult->get();
            $currentPage = (int) $queryPage;
            $nextPage = $queryPage < $totalPage ? $queryPage + 1 : null;
            $prevPage = $queryPage > 1 ? $queryPage - 1 : null;
            $data = [
                'pages' => [
                    'total_data' => $totalData,
                    'total_page' => $totalPage,
                    'current_page' => $currentPage,
                    'next_page' => $nextPage,
                    'prev_page' => $prevPage,
                ],
                'data' => $contactMessages,
            ];
            if (!$contactMessages) return $this->generateResponse->response404();
            return $this->generateResponse->response200($data, 'Contact Messages Retrieved');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rules = [
                'full_name' => 'required|string',
                'email' => 'required|email',
                'phone_number' => 'required|string',
                'message' => 'required|string',
            ];
            $validator = validator()->make($request->all(), $rules);
            if ($validator->fails()) return $this->generateResponse->response400('Bad Request', $validator->errors());
            $contactMessage = new ContactMessage();
            $contactMessage->full_name = $request->full_name;
            $contactMessage->email = $request->email;
            $contactMessage->phone_number = $request->phone_number;
            $contactMessage->message = $request->message;
            $contactMessage->status_code = '004^001'; // 004^001 = Unread
            $contactMessage->save();
            return $this->generateResponse->response201($contactMessage, 'Contact Message Created');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function status(Request $request, string $id)
    {
        try {
            $rules = [
                'status_code' => 'required|string|exists:generic_codes,generic_code_id',
            ];
            $validator = validator()->make($request->all(), $rules);
            if ($validator->fails()) return $this->generateResponse->response400('Bad Request', $validator->errors());
            $contactMessage = ContactMessage::find($id);
            if (!$contactMessage) return $this->generateResponse->response404();
            $contactMessage->status_code = $request->status_code;
            if ($request->status_code === "004^002") $contactMessage->isRead = true;
            if ($request->status_code === "004^003") $contactMessage->isSpam = true;
            if ($request->status_code === "004^004") $contactMessage->isStarred = true;
            $contactMessage->save();
            return $this->generateResponse->response200($contactMessage, 'Contact Message Updated');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $contactMessage = ContactMessage::find($id);
            if (!$contactMessage) return $this->generateResponse->response404();
            $contactMessage->delete();
            return $this->generateResponse->response201(null, 'Contact Message Deleted');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
