<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    public function index(){
      $total_users = Customer::count();
      $total_allowed_users = Customer::where('is_allowed',1)->count();
      $this_month_registered_users = $this->getThisMonthRegisteredUsers();
      $total_allowed_balance = Customer::where('is_allowed', 1)->sum('real_balance');
      $total_balance = Customer::sum('real_balance');
      return view('dashboard',compact('total_users','total_balance','total_allowed_users','this_month_registered_users','total_allowed_balance'));
    }

  public function getThisMonthRegisteredUsers()
  {
      $currentYear = Carbon::now()->year;
      $currentMonth = Carbon::now()->month;
      $daysInMonth = Carbon::now()->daysInMonth;

      $users = Customer::whereYear('created_at', $currentYear)
        ->whereMonth('created_at', $currentMonth)
        ->get();

      $dataset = [];
      $labels = [];
      $registrationCount = array_fill(1, $daysInMonth, 0);

      foreach ($users as $user) {
        $dayOfMonth = $user->created_at->day;
        $registrationCount[$dayOfMonth]++;
      }

      foreach ($registrationCount as $day => $count) {
        $dataset[] = $count;
        $labels[] = $day;
      }

      $data = [
        'labels' => $labels,
        'data' => $dataset,
      ];

      return $data;
  }
}
