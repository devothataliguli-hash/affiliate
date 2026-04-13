<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Get total users count
        $totalUsers = User::count();

        // Get active skills for the value section (limit to 4)
        $featuredSkills = Skill::where('is_active', true)
            ->orderBy('price', 'asc')
            ->take(4)
            ->get();

        // Get active testimonials (limit to 3)
        $testimonials = Testimonial::where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        // Get premium team management skills (for the team section)
        $teamSkills = Skill::where('is_active', true)
            ->where(function ($query) {
                $query->where('name', 'like', '%team%')
                    ->orWhere('name', 'like', '%Team%')
                    ->orWhere('price', '>', 0);
            })
            ->take(2)
            ->get();

        // If no team skills found, provide fallback
        if ($teamSkills->isEmpty()) {
            $teamSkills = collect([
                (object)[
                    'id' => 1,
                    'name' => 'Kozi: Jinsi ya Kujenga Team Yenye Nguvu',
                    'price' => 20000,
                    'description' => 'Mbinu za kuvutia wanachama bora, Kuweka malengo na kufuatilia, Kuunda utamaduni wa timu'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Kozi: Mbinu za Kuongeza Performance ya Team',
                    'price' => 25000,
                    'description' => 'Kuongeza mauzo kwa timu kubwa, Mawasiliano bora na migogoro, Motisha na tija'
                ]
            ]);
        }

        return view('landing', compact('totalUsers', 'featuredSkills', 'testimonials', 'teamSkills'));
    }
}