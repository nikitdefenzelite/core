<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202402-V2.0>
 * @link    <https://www.defenzelite.com>
 */

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Role;
use App\Http\Requests\UserRequest;
use App\Models\ApiRunnerLog;
use App\Models\CyRunnerLog;

class DashboardController extends Controller
{

    public $label;

    function __construct()
    {
        $this->label = 'Dashboard';
    }
    public function index()
    {
        $latestMonth = now();
        $previousMonth = $latestMonth->subMonth();
        $count = User::whereRoleIs(['User'])->whereBetween('created_at', [$previousMonth, $latestMonth])->count();
        $newUser =  $count > 0 ? '+'.$count : 0;
        // $count = Order::whereBetween('created_at', [$previousMonth, $latestMonth])->count();
        // $newOrder = $count > 0 ? '+'.$count : 0;
        $user = auth()->user();
        $label = $this->label;
        // $readNotifications = Notification::where('user_id', auth()->id())->where('is_read', 1)->get();
        // $unreadNotifications = Notification::where('user_id', auth()->id())->where('is_read', 0)->get();
        // $stats['adminsCount']  = User::whereRoleIs(['Admin'])->count();
        // $stats['customersCount']  = User::whereRoleIs(['customers'])->count();
        // $stats['leadConversationsCount']  = Conversation::where('type', Lead::class)->groupBy('type_id')->count();
        // $stats['leadsCount']  = Lead::where('lead_type_id', 5)->count();
        // $orders  = Order::where('payment_status', '!=', 1)->get();
        // dd($stats);
        $projectCount  = Project::count();
        $cyRunnerLogCount  = CyRunnerLog::count();
        $apiRunnerLogCount  = ApiRunnerLog::count();
        return view('panel.admin.dashboard.index', compact('user', 'label','newUser','projectCount','cyRunnerLogCount','apiRunnerLogCount'));
    }
    public function createModule()
    {
        $roles =Role::whereNotIn('id', [1])->pluck('display_name');
        return view('panel.admin.module.create', compact('roles'));
    }

    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (!auth()->user()) {
            return redirect()->url('/');
        }

        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id

            if (auth()->user()->hasRole('user')) {
                $role = "?role=User";
            } else {
                $role = "?role=Admin";
            }
            $admin_id = session()->get('admin_user_id');

            session()->forget('admin_user_id');
            session()->forget('admin_user_name');
            session()->forget('temp_user_id');

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            return redirect(route('panel.admin.users.index').$role);
        } else {
            // return 'f';
            session()->forget('admin_user_id');
            session()->forget('admin_user_name');
            session()->forget('temp_user_id');

            // Otherwise logout and redirect to login
            auth()->logout();

            return redirect('/');
        }
    }
}
