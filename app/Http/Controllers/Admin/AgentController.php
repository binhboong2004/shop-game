<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AgentController extends Controller
{
    public function index()
    {
        $agents = User::where('role', 'agent')->paginate(10);
        $totalAgents = User::where('role', 'agent')->count();
        $totalBalance = User::where('role', 'agent')->sum('balance');
        $activeAgents = User::where('role', 'agent')->where('status', 'active')->count();
        $pendingOrBanned = User::where('role', 'agent')->whereIn('status', ['pending', 'banned'])->count();

        return view('admin.pages.taikhoandaily', compact(
            'agents', 'totalAgents', 'totalBalance', 'activeAgents', 'pendingOrBanned'
        ));
    }

    public function create()
    {
        return view('admin.pages.themdaily');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'balance' => 'nullable|numeric|min:0',
            'level' => 'nullable|integer|min:1',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
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
            'level' => $request->level ?? 1,
            'discount_rate' => $request->discount_rate ?? 15,
            'role' => 'agent',
            'status' => $request->has('is_active') ? 'active' : 'pending',
        ];

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $userData['avatar'] = 'uploads/avatars/' . $filename;
        }

        User::create($userData);

        return redirect()->route('admin.taikhoandaily')->with('success', 'Thêm đại lý mới thành công!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.pages.themdaily', compact('user'));
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
            'level' => 'nullable|integer|min:1',
            'discount_rate' => 'nullable|numeric|min:0|max:100',
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
            'level' => $request->level ?? 1,
            'discount_rate' => $request->discount_rate ?? 15,
            'status' => $request->has('is_active') ? 'active' : ($user->status == 'pending' ? 'pending' : 'banned'),
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

        return redirect()->route('admin.taikhoandaily')->with('success', 'Cập nhật đại lý thành công!');
    }

    public function lock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'banned']);
        return redirect()->route('admin.taikhoandaily')->with('success', 'Đã khóa đại lý thành công!');
    }

    public function unlock($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return redirect()->route('admin.taikhoandaily')->with('success', 'Đã mở khóa đại lý!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }
        
        $user->delete();
        
        return redirect()->route('admin.taikhoandaily')->with('success', 'Đã xóa đại lý!');
    }

    public function promote(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'role' => 'required|in:admin,member'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return redirect()->route('admin.taikhoandaily')->with('success', 'Phân quyền thành công!');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 'active',
            'role' => 'agent'
        ]);
        return redirect()->route('admin.taikhoandaily')->with('success', 'Đã duyệt đại lý!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => 'active',
            'role' => 'member'
        ]);
        return redirect()->route('admin.taikhoandaily')->with('success', 'Đã từ chối đại lý, người dùng được trả về thành viên!');
    }
}
