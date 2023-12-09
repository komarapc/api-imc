<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WebVisitor;
use App\Services\GenerateResponse;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class WebVisitorController extends Controller
{
    protected $generateResponse;
    public function __construct(GenerateResponse $generateResponse)
    {
        $this->generateResponse = $generateResponse;
    }

    public function index()
    {
        try {
            $queryStartDate = request()->query('start_date');
            $queryEndDate = request()->query('end_date');
            $queryPage = request()->query('page') ? request()->query('page') : 1;
            $queryLimit = request()->query('limit') ? request()->query('limit') : $this->generateResponse->limit;
            $querySort = request()->query('sort') ? request()->query('sort') : 'created_at';

            $queryResult = WebVisitor::query();
            if ($queryStartDate && $queryEndDate) $queryResult->whereBetween('created_at', [$queryStartDate, $queryEndDate]);
            $queryResult->orderBy($querySort, 'desc');
            $totalData = $queryResult->count();
            $totalPage = ceil($totalData / $queryLimit);
            $queryResult->offset(($queryPage - 1) * $queryLimit);
            $queryResult->limit($queryLimit);
            $data = $queryResult->get();

            $currentPage = $queryPage > $totalPage ? $totalPage : $queryPage;
            $previousPage = $currentPage - 1 < 1 ? null : $currentPage - 1;
            $nextPage = $currentPage + 1 > $totalPage ? null : $currentPage + 1;
            $data = [
                'page' => [
                    'current_page' => $currentPage,
                    'previous_page' => $previousPage,
                    'next_page' => $nextPage,
                    'total_page' => $totalPage,
                    'total_data' => $totalData,
                ],
                'data' => $data,
            ];
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
    public function show(string $id)
    {
        try {
            $data = WebVisitor::findOrFail($id);
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function store(Request $request)
    {
        try {
            $web_visitor = new WebVisitor();
            $agent = new Agent($request->server());
            $web_visitor->ip_address = $request->ip();
            $web_visitor->user_agent = $request->userAgent();
            $web_visitor->browser = $agent->browser();
            $web_visitor->browser_version = $agent->version($agent->browser());
            $web_visitor->platform = $agent->platform();
            $web_visitor->platform_version = $agent->version($agent->platform());
            $web_visitor->device = $agent->device();
            $web_visitor->device_type = $agent->isPhone() ? 'phone' : ($agent->isTablet() ? 'tablet' : ($agent->isDesktop() ? 'desktop' : null));

            $web_visitor->save();
            return $this->generateResponse->response201($web_visitor, 'Data has been created');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
    public function destroy(string $id)
    {
        try {
            $data = WebVisitor::findOrFail($id);
            $data->delete();
            return $this->generateResponse->response201(null, 'Data has been deleted');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function statistic()
    {
        try {
            $queryResult = WebVisitor::query();
            $queryResult->selectRaw('COUNT(*) as total');
            $totalVisitor = $queryResult->first();

            $data = [
                'total_visitor' => $totalVisitor->total,
                'last_five_years' => $this->staticVisitorLast5Years()->original['data'],
                'yearly_visitor' => $this->staticYearlyVisitor()->original['data'],
                'monthly_visitor' => $this->staticMonthlyVisitorByCurrentYear()->original['data'],
                'today_visitor' => $this->staticTodayVisitor()->original['data'],
            ];
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    private function staticYearlyVisitor()
    {
        try {
            $queryResult = WebVisitor::query();
            $queryResult->selectRaw('YEAR(created_at) as year, COUNT(*) as total');
            $queryResult->groupBy('year');
            $queryResult->orderBy('year', 'asc');
            $data = $queryResult->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    private function staticMonthlyVisitorByCurrentYear()
    {
        try {

            $queryResult = WebVisitor::query();
            $queryResult->selectRaw('MONTH(created_at) as month, COUNT(*) as total');
            $queryResult->whereYear('created_at', date('Y'));
            $queryResult->groupBy('month');
            $queryResult->orderBy('month', 'asc');
            $data = $queryResult->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    private function staticTodayVisitor()
    {
        try {
            $queryResult = WebVisitor::query();
            $queryResult->selectRaw('DATE(created_at) as date, COUNT(*) as total');
            $queryResult->groupBy('date');
            $queryResult->orderBy('date', 'asc');
            $data = $queryResult->get();
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }

    public function staticVisitorLast5Years()
    {
        try {
            $queryResult = WebVisitor::query();
            $queryResult->selectRaw('YEAR(created_at) as year, COUNT(*) as total');
            $queryResult->groupBy('year');
            $queryResult->orderBy('year', 'asc');
            $data = $queryResult->get();
            $data = $data->pluck('total', 'year');
            $data = $data->toArray();
            $data = array_reverse($data);
            $data = array_slice($data, 0, 5);
            return $this->generateResponse->response200($data, 'Success');
        } catch (\Throwable $th) {
            return $this->generateResponse->response500('Internal Server Error', env('APP_DEBUG') ? $th->getMessage() : null);
        }
    }
}
