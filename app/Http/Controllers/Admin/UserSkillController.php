<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserSkillController extends Controller
{
    public function index()
    {
        $userSkills = DB::table('user_skills')
            ->join('users', 'user_skills.user_id', '=', 'users.id')
            ->join('skills', 'user_skills.skill_id', '=', 'skills.id')
            ->select('user_skills.*', 'users.name as user_name', 'users.email', 'users.phone', 'skills.name as skill_name')
            ->orderBy('user_skills.created_at', 'desc')
            ->paginate(15);

        return view('admin.user-skills.index', compact('userSkills'));
    }

    public function approve($id)
    {
        DB::table('user_skills')->where('id', $id)->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return back()->with('success', 'User ameidhinishwa kupata skill.');
    }

    public function reject($id)
    {
        DB::table('user_skills')->where('id', $id)->delete();
        return back()->with('success', 'Ombi limekataliwa.');
    }
}