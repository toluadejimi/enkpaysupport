<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Services\NewsService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use ResponseTrait;

    public $tradeService;
    public $newsService;
    public $hardwareService;
    public $walletService;

    public function __construct()
    {
        $this->newsService = new NewsService;
    }

    public function index(Request $request)
    {
        $data['activeDashboard'] = 'active-menu';
        $data['news'] = $this->newsService->getAllNews();

        return view('user.dashboard', $data);
    }
}
