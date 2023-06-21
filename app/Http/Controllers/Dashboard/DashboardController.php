<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Task;
use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('control-panel.dashboard.index', [
            'statistics' => [
                'Users' => User::count(),
                'Clients' => Client::count(),
                'Organizations' => Organization::count(),
                'Projects' => Project::count(),
                'Tasks' => Task::count(),
            ],
        ]);
    }

    public function search()
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters(['name'])
            ->get();
        $projects = QueryBuilder::for(Project::class)
            ->allowedFilters(['description'])
            ->get();
    }
}
