<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use AdminViewsManager;

class DashboardController extends Controller
{
    /**
     * Returns the main admin page, the dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.index')
            ->with(AdminViewsManager::getAdminDashboard());
    }
}
