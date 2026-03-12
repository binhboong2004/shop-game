<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'member');

        // Tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Sắp xếp
        if ($request->has('sort')) {
            if ($request->sort == 'balance') {
                $query->orderBy('balance', 'desc');
            } else {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $users = $query->paginate(10);
        $users->appends($request->all());

        // Thống kê
        $totalUsers = User::where('role', 'member')->count();
        $newUsers24h = User::where('role', 'member')->where('created_at', '>=', now()->subDay())->count();
        $activeUsers = User::where('role', 'member')->where('status', 'active')->count();
        $bannedUsers = User::where('role', 'member')->where('status', 'banned')->count();

        return view('admin.pages.taikhoanthanhvien', compact(
            'users', 
            'totalUsers', 
            'newUsers24h', 
            'activeUsers', 
            'bannedUsers'
        ));
    }

    public function create()
    {
        return view('admin.pages.themthanhvien');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'balance' => 'nullable|numeric|min:0',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'balance' => $request->balance ?? 0,
            'role' => 'member',
            'status' => $request->has('is_active') ? 'active' : 'banned',
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $userData['avatar'] = 'uploads/avatars/' . $filename;
        }

        User::create($userData);

        return redirect()->route('admin.taikhoanthanhvien')->with('success', 'Thêm thành viên mới thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.themthanhvien', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'balance' => 'nullable|numeric|min:0',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'avatar.image' => 'File tải lên phải là hình ảnh.',
            'avatar.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'balance' => $request->balance ?? 0,
            'status' => $request->has('is_active') ? 'active' : 'banned',
        ];

        if ($request->filled('password')) {
            $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $userData['avatar'] = 'uploads/avatars/' . $filename;
            
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }
        }

        $user->update($userData);

        return redirect()->route('admin.taikhoanthanhvien')->with('success', 'Cập nhật thành viên thành công!');
    }

    public function lock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);
        return redirect()->route('admin.taikhoanthanhvien')->with('success', 'Đã khóa tài khoản thành công!');
    }

    public function unlock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return redirect()->route('admin.taikhoanthanhvien')->with('success', 'Đã mở khóa tài khoản!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }
        
        $user->delete();
        
        return redirect()->route('admin.taikhoanthanhvien')->with('success', 'Đã xóa thành viên!');
    }

    public function promote(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:admin,agent,member'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->route('admin.taikhoanthanhvien')->with('success', 'Phân quyền thành công!');
    }
}
