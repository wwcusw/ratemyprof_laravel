<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Evaluation;

class FacultyController extends Controller
{
    public function showResults()
    {
        $user = Auth::user();

        // Check if results are published
        $published = DB::table('settings')->where('key', 'results_published')->value('value') === '1';

        $averageScores = [];
        $evaluations = collect(); // Default empty collection
        $currentSemester = null;

        if ($published) {
            // Get current semester from settings
            $currentSemester = DB::table('settings')->where('key', 'current_semester')->value('value');
            $evaluations = Evaluation::where('faculty_user_id', $user->user_id)
                ->where('semester', $currentSemester)
                ->get();

            if ($evaluations->count()) {
                for ($i = 1; $i <= 10; $i++) {
                    $avg = $evaluations->avg('q' . $i);
                    $averageScores['q' . $i] = round($avg, 2);
                }
            }
        }

        return view('faculty.results', compact('averageScores', 'published', 'evaluations', 'currentSemester'));
    }
}
