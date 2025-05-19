<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 

class EvaluationController extends Controller
{
    /**
     * Show the evaluation form to the student.
     */
    public function showForm()
{
    $professors = User::where('role', 'faculty')->get();

    $currentSemester = DB::table('settings')->where('key', 'current_semester')->value('value');

    return view('student.evaluation-form', compact('professors', 'currentSemester'));
}


    /**
     * Store a submitted evaluation.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'faculty_user_id' => 'required|string|exists:users,user_id',
            'q1' => 'required|integer|min:1|max:5',
            'q2' => 'required|integer|min:1|max:5',
            'q3' => 'required|integer|min:1|max:5',
            'q4' => 'required|integer|min:1|max:5',
            'q5' => 'required|integer|min:1|max:5',
            'q6' => 'required|integer|min:1|max:5',
            'q7' => 'required|integer|min:1|max:5',
            'q8' => 'required|integer|min:1|max:5',
            'q9' => 'required|integer|min:1|max:5',
            'q10' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'semester' => 'required|string|max:50',
        ]);

        $studentId = Auth::id();
        $facultyId = $request->input('faculty_user_id');
        $semester = $request->input('semester');

        // Prevent duplicate evaluation per professor per semester
        $alreadySubmitted = Evaluation::where('user_id', $studentId)
            ->where('faculty_user_id', $facultyId)
            ->where('semester', $semester)
            ->exists();

        if ($alreadySubmitted) {
            return back()->with('error', 'You have already submitted an evaluation for this professor this semester.');
        }

        $data['user_id'] = $studentId;

        Evaluation::create($data);

        return back()->with('success', 'Evaluation submitted successfully!');
    }

    /**
     * Show average results to faculty.
     */
    public function facultyResults()
    {
        $user = Auth::user(); // logged-in faculty

        $averageScores = [];

        $evaluations = Evaluation::where('faculty_user_id', $user->user_id)->get();

        if ($evaluations->count() > 0) {
            for ($i = 1; $i <= 10; $i++) {
                $averageScores["q$i"] = round($evaluations->avg("q$i"), 2);
            }
        }

        return view('faculty.results', compact('averageScores'));
    }
}
