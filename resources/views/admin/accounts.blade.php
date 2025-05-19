<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manage Accounts
        </h2>
    </x-slot>

    @if(auth()->check() && auth()->user()->role === 'admin')
    <div class="py-12 flex flex-col items-center">
        <div class="max-w-4xl mx-auto w-full">
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl p-10 mt-16">
                <h3 class="text-2xl font-bold mb-8 text-center text-gray-800 dark:text-gray-100">Create New Account</h3>
                <form method="POST" action="{{ route('admin.createAccount') }}">
                    @csrf
                    <div class="max-w-3xl mx-auto space-y-4">
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Email</label>
                            <input type="email" name="email" id="email" required class="w-full border rounded-lg px-4 py-3 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" placeholder="Enter email">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Password</label>
                            <input type="password" name="password" id="password" required class="w-full border rounded-lg px-4 py-3 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" placeholder="Enter password">
                        </div>
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Username</label>
                            <input type="text" name="username" id="username" class="w-full border rounded-lg px-4 py-3 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" placeholder="Enter username (optional)">
                        </div>
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-600 dark:text-gray-300 mb-1">Role</label>
                            <select name="role" id="role" required class="w-full border rounded-lg px-4 py-3 dark:bg-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500">
                                <option value="student">Student</option>
                                <option value="faculty">Faculty</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg mt-4 transition">Create Account</button>
                    </div>
                </form>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow-xl p-8 w-full mt-8">
                <h3 class="text-lg font-semibold mb-6 text-center text-gray-800 dark:text-gray-200">All Accounts</h3>
                <div class="w-full overflow-x-auto">
                    <table class="w-full text-sm border dark:border-gray-700 text-left">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <tr>
                                <th class="px-6 py-3">User ID</th>
                                <th class="px-6 py-3">Email</th>
                                <th class="px-6 py-3">Username</th>
                                <th class="px-6 py-3">Role</th>
                                <th class="px-6 py-3">Password</th>
                                <th class="px-6 py-3">Created At</th>
                                <th class="px-6 py-3 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200">
                            @foreach (\App\Models\User::all() as $user)
                                <tr class="align-middle hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                    <form method="POST" action="{{ route('admin.updateAccount', $user->id) }}" class="contents">
                                        @csrf
                                        @method('PUT')
                                        <td class="px-6 py-3">{{ $user->user_id }}</td>
                                        <td class="px-6 py-3">
                                            <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm dark:bg-gray-900 dark:text-gray-100 mt-1 mb-1">
                                        </td>
                                        <td class="px-6 py-3">
                                            <input type="text" name="username" value="{{ $user->username }}" class="w-full border rounded px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm dark:bg-gray-900 dark:text-gray-100 mt-1 mb-1" placeholder="Username">
                                        </td>
                                        <td class="px-6 py-3">
                                            <select name="role" class="w-full border rounded px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm dark:bg-gray-900 dark:text-gray-100 mt-1 mb-1">
                                                <option value="student" @if($user->role=='student') selected @endif>Student</option>
                                                <option value="faculty" @if($user->role=='faculty') selected @endif>Faculty</option>
                                                <option value="admin" @if($user->role=='admin') selected @endif>Admin</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-3">
                                            <input type="password" name="password" placeholder="New password" class="w-full border rounded px-2 py-1 sm:px-4 sm:py-2 text-xs sm:text-sm dark:bg-gray-900 dark:text-gray-100 mt-1 mb-1">
                                        </td>
                                        <td class="px-6 py-3">{{ $user->created_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-6 py-3 text-center">
                                            <div class="flex gap-2 justify-center">
                                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-2 py-1 sm:px-5 sm:py-2 text-xs sm:text-sm rounded">Save</button>
                                            </div>
                                        </td>
                                    </form>
                                    <td class="px-6 py-3 text-center">
                                        <form method="POST" action="{{ route('admin.deleteAccount', $user->id) }}" onsubmit="return confirm('Are you sure you want to archive/delete this account?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 sm:px-5 sm:py-2 text-xs sm:text-sm rounded">Archive</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-red-500 text-center mt-10 text-lg">
        Unauthorized access.
    </div>
    @endif
</x-layout> 