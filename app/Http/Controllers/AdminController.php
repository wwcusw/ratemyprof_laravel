<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function showEvaluations(Request $request)
    {
        $semester = $request->input('semester');
        $published = $this->isResultsPublished();

        $evaluations = Evaluation::with(['student', 'professor'])
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->get();

        return view('admin.evaluations', [
            'evaluations' => $evaluations,
            'published' => $published,
        ]);
    }

    public function toggleResults()
    {
        $published = $this->isResultsPublished();
        DB::table('settings')->updateOrInsert(
            ['key' => 'results_published'],
            ['value' => $published ? '0' : '1']
        );

        return redirect()->route('admin.evaluations');
    }

    // ✅ Fixed method name to match route: 'admin.setSemester'
    public function setSemester(Request $request)
    {
        $request->validate(['semester' => 'required|string|max:50']);

        DB::table('settings')->updateOrInsert(
            ['key' => 'current_semester'],
            ['value' => $request->semester]
        );

        return redirect()->route('admin.evaluations')->with('success', 'Semester updated.');
    }

    public function createAccount(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:student,faculty,admin',
            'username' => 'nullable|string|unique:users,username',
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->name = strstr($request->email, '@', true);
        $user->username = $request->username;
        $user->save();

        return redirect()->route('admin.accounts')->with('success', 'Account created successfully.');
    }

    public function updateAccount(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:student,faculty,admin',
            'username' => 'nullable|string|unique:users,username,' . $id,
        ]);

        $user = User::findOrFail($id);
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->username = $request->username;
        $user->save();

        return redirect()->route('admin.accounts')->with('success', 'Account updated successfully.');
    }

    public function deleteAccount($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.accounts')->with('success', 'Account deleted successfully.');
    }

    private function isResultsPublished(): bool
    {
        return DB::table('settings')->where('key', 'results_published')->value('value') === '1';
    }
}
