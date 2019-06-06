<?php
/**
 * Created by PhpStorm.
 * User: molde
 * Date: 05.06.2019
 * Time: 19:13
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
  public function index()
  {
      return view('admin/home');
  }
}