<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Clients\CartController;
use App\Http\Controllers\Clients\WishlistController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/hotro', [HomeController::class, 'hotro'])->name('hotro');

Route::get('/magiamgia', [HomeController::class, 'magiamgia'])->name('magiamgia');

Route::get('/napnganhang', [HomeController::class, 'napnganhang'])->name('napnganhang');

Route::get('/napthecao', [HomeController::class, 'napthecao'])->name('napthecao');

Route::get('/sanpham', [HomeController::class, 'sanpham'])->name('sanpham');

Route::get('/sanphamchitiet/{id}', [HomeController::class, 'sanphamchitiet'])->name('sanphamchitiet');

Route::get('/tintuc', [HomeController::class, 'tintuc'])->name('tintuc');

Route::middleware(['auth'])->group(function () {
    Route::get('/giohang', [CartController::class, 'index'])->name('giohang');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/yeuthich', [WishlistController::class, 'index'])->name('yeuthich');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    
    Route::post('/nap-ngan-hang/submit', [HomeController::class, 'submitBankDeposit'])->name('bank.submit');
    
    Route::post('/thongtincanhan/update', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::post('/thongtincanhan/password', [HomeController::class, 'updatePassword'])->name('profile.password');
    Route::get('/thongtincanhan', [HomeController::class, 'thongtincanhan'])->name('thongtincanhan');

    Route::get('/lichsunaptien', [HomeController::class, 'lichsunaptien'])->name('lichsunaptien');
    Route::get('/lichsumuahang', [HomeController::class, 'lichsumuahang'])->name('lichsumuahang');
});

Route::get('/vongquay', function () {
    return view('clients.pages.vongquay');
})->name('vongquay');

Route::get('/vongquay/{id}', [HomeController::class, 'vongquaychitiet'])->name('vongquaychitiet');



use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Email Verification custom Route
Route::get('/email/verify/{token}', [VerificationController::class, 'verifyToken'])->name('verification.verify_token');


Route::get('/dangnhap', function () {
    return view('clients.pages.dangnhap');
})->name('dangnhap');
Route::post('/dangnhap', [AuthController::class, 'login'])->name('login.post');

Route::get('/dangky', function () {
    return view('clients.pages.dangky');
})->name('dangky');
Route::post('/dangky', [AuthController::class, 'register'])->name('register.post');

Route::post('/dangxuat', [AuthController::class, 'logout'])->name('logout');

Route::get('/dang-ky-dai-ly', function () {
    return view('clients.pages.dangkydaily');
})->name('dangkydaily');

// Agent Routes
Route::prefix('agent')->middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', function () {
        return view('agents.pages.dashboard');
    })->name('agent.dashboard');
    
    Route::get('/dang-nick-moi', function () {
        return view('agents.pages.dangnickmoi');
    })->name('agent.dangnickmoi');
    
    Route::get('/ruttien', function () {
        return view('agents.pages.ruttien');
    })->name('agent.ruttien');

    // Kho Nick Của Tôi
    Route::get('/khonickcuatoi', function () {
        return view('agents.pages.khonickcuatoi');
    })->name('agent.khonickcuatoi');

    // Lịch sử rút tiền
    Route::get('/lich-su-rut-tien', function () {
        return view('agents.pages.lichsuruttien');
    })->name('agent.lichsuruttien');

    // Thống kê cá nhân
    Route::get('/thongke', function () {
        return view('agents.pages.thongkecanhan');
    })->name('agent.thongke');
});

use App\Http\Controllers\Admin\DashboardController;

// Admin Routes
Route::prefix('admin')->group(function() {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/tai-khoan-dai-ly', [App\Http\Controllers\Admin\AgentController::class, 'index'])->name('admin.taikhoandaily');
    Route::get('/them-dai-ly', [App\Http\Controllers\Admin\AgentController::class, 'create'])->name('admin.themdaily');
    Route::post('/them-dai-ly', [App\Http\Controllers\Admin\AgentController::class, 'store'])->name('admin.themdaily.store');
    
    // Agent action routes
    Route::get('/dai-ly/{id}/edit', [App\Http\Controllers\Admin\AgentController::class, 'edit'])->name('admin.daily.edit');
    Route::put('/dai-ly/{id}', [App\Http\Controllers\Admin\AgentController::class, 'update'])->name('admin.daily.update');
    Route::put('/dai-ly/{id}/lock', [App\Http\Controllers\Admin\AgentController::class, 'lock'])->name('admin.daily.lock');
    Route::put('/dai-ly/{id}/unlock', [App\Http\Controllers\Admin\AgentController::class, 'unlock'])->name('admin.daily.unlock');
    Route::delete('/dai-ly/{id}', [App\Http\Controllers\Admin\AgentController::class, 'destroy'])->name('admin.daily.destroy');
    Route::put('/dai-ly/{id}/promote', [App\Http\Controllers\Admin\AgentController::class, 'promote'])->name('admin.daily.promote');
    Route::put('/dai-ly/{id}/approve', [App\Http\Controllers\Admin\AgentController::class, 'approve'])->name('admin.daily.approve');
    Route::put('/dai-ly/{id}/reject', [App\Http\Controllers\Admin\AgentController::class, 'reject'])->name('admin.daily.reject');

    Route::get('/tai-khoan-admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.taikhoanadmin');
    Route::get('/them-admin', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('admin.themadmin');
    Route::post('/them-admin', [App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admin.themadmin.store');
    
    // Admin action routes
    Route::get('/admin-user/{id}/edit', [App\Http\Controllers\Admin\AdminController::class, 'edit'])->name('admin.admin.edit');
    Route::put('/admin-user/{id}', [App\Http\Controllers\Admin\AdminController::class, 'update'])->name('admin.admin.update');
    Route::put('/admin-user/{id}/lock', [App\Http\Controllers\Admin\AdminController::class, 'lock'])->name('admin.admin.lock');
    Route::put('/admin-user/{id}/unlock', [App\Http\Controllers\Admin\AdminController::class, 'unlock'])->name('admin.admin.unlock');
    Route::delete('/admin-user/{id}', [App\Http\Controllers\Admin\AdminController::class, 'destroy'])->name('admin.admin.destroy');
    Route::put('/admin-user/{id}/promote', [App\Http\Controllers\Admin\AdminController::class, 'promote'])->name('admin.admin.promote');

    Route::get('/tai-khoan-thanh-vien', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.taikhoanthanhvien');
    Route::get('/them-thanh-vien', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.themthanhvien');
    Route::post('/them-thanh-vien', [App\Http\Controllers\Admin\UserController::class, 'store'])->name('admin.themthanhvien.store');
    
    // Member action routes
    Route::get('/thanh-vien/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.thanhvien.edit');
    Route::put('/thanh-vien/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.thanhvien.update');
    Route::put('/thanh-vien/{id}/lock', [App\Http\Controllers\Admin\UserController::class, 'lock'])->name('admin.thanhvien.lock');
    Route::put('/thanh-vien/{id}/unlock', [App\Http\Controllers\Admin\UserController::class, 'unlock'])->name('admin.thanhvien.unlock');
    Route::delete('/thanh-vien/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.thanhvien.destroy');
    Route::put('/thanh-vien/{id}/promote', [App\Http\Controllers\Admin\UserController::class, 'promote'])->name('admin.thanhvien.promote');

    Route::get('/cau-hinh-thuoc-tinh', [App\Http\Controllers\Admin\AttributeController::class, 'index'])->name('admin.cauhinhthuoctinh');
    Route::post('/cau-hinh-thuoc-tinh', [App\Http\Controllers\Admin\AttributeController::class, 'store'])->name('admin.cauhinhthuoctinh.store');
    Route::put('/cau-hinh-thuoc-tinh/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'update'])->name('admin.cauhinhthuoctinh.update');
    Route::delete('/cau-hinh-thuoc-tinh/{id}', [App\Http\Controllers\Admin\AttributeController::class, 'destroy'])->name('admin.cauhinhthuoctinh.destroy');
    Route::patch('/cau-hinh-thuoc-tinh/{id}/toggle-status', [App\Http\Controllers\Admin\AttributeController::class, 'toggleStatus'])->name('admin.cauhinhthuoctinh.toggleStatus');

    Route::get('/cau-hinh-chung', function () {
        return view('admin.pages.cauhinhchung');
    })->name('admin.cauhinhchung');

    Route::get('/quan-ly-nap-tien', function () {
        return view('admin.pages.quanlynaptien');
    })->name('admin.quanlynaptien');

    Route::get('/quan-ly-danh-muc', [App\Http\Controllers\Admin\GameController::class, 'index'])->name('admin.quanlydanhmuc');
    Route::post('/quan-ly-danh-muc', [App\Http\Controllers\Admin\GameController::class, 'store'])->name('admin.quanlydanhmuc.store');
    Route::put('/quan-ly-danh-muc/{id}', [App\Http\Controllers\Admin\GameController::class, 'update'])->name('admin.quanlydanhmuc.update');
    Route::delete('/quan-ly-danh-muc/{id}', [App\Http\Controllers\Admin\GameController::class, 'destroy'])->name('admin.quanlydanhmuc.destroy');
    Route::patch('/quan-ly-danh-muc/{id}/toggle-status', [App\Http\Controllers\Admin\GameController::class, 'toggleStatus'])->name('admin.quanlydanhmuc.toggleStatus');

    Route::get('/quan-ly-danh-muc-con', [App\Http\Controllers\Admin\GameCategoryController::class, 'index'])->name('admin.quanlydanhmuccon');
    Route::post('/quan-ly-danh-muc-con', [App\Http\Controllers\Admin\GameCategoryController::class, 'store'])->name('admin.quanlydanhmuccon.store');
    Route::put('/quan-ly-danh-muc-con/{id}', [App\Http\Controllers\Admin\GameCategoryController::class, 'update'])->name('admin.quanlydanhmuccon.update');
    Route::delete('/quan-ly-danh-muc-con/{id}', [App\Http\Controllers\Admin\GameCategoryController::class, 'destroy'])->name('admin.quanlydanhmuccon.destroy');
    Route::patch('/quan-ly-danh-muc-con/{id}/toggle-status', [App\Http\Controllers\Admin\GameCategoryController::class, 'toggleStatus'])->name('admin.quanlydanhmuccon.toggleStatus');

    Route::get('/danh-sach-nick', [App\Http\Controllers\Admin\AccountController::class, 'index'])->name('admin.danhsachnick');
    Route::patch('/quan-ly-nick/{id}/toggle-status', [App\Http\Controllers\Admin\AccountController::class, 'toggleStatus'])->name('admin.quanlynick.toggleStatus');
    Route::delete('/quan-ly-nick/{id}', [App\Http\Controllers\Admin\AccountController::class, 'destroy'])->name('admin.quanlynick.destroy');

    Route::get('/kiem-duyet-nick', [App\Http\Controllers\Admin\AccountController::class, 'kiemDuyetNick'])->name('admin.kiemduyetnick');
    Route::put('/kiem-duyet-nick/{id}/approve', [App\Http\Controllers\Admin\AccountController::class, 'approve'])->name('admin.kiemduyetnick.approve');
    Route::put('/kiem-duyet-nick/{id}/reject', [App\Http\Controllers\Admin\AccountController::class, 'reject'])->name('admin.kiemduyetnick.reject');

    Route::get('/kiem-duyet-rut-tien', function () {
        return view('admin.pages.kiemduyetruttien');
    })->name('admin.kiemduyetruttien');     

    Route::get('/lich-su-ban-hang', function () {
        return view('admin.pages.lichsubanhang');
    })->name('admin.lichsubanhang');

    Route::get('/ma-giam-gia', function () {
        return view('admin.pages.magiamgia');
    })->name('admin.magiamgia');

    Route::get('/them-nick-moi', [App\Http\Controllers\Admin\AccountController::class, 'create'])->name('admin.themnickmoi');
    Route::post('/them-nick-moi', [App\Http\Controllers\Admin\AccountController::class, 'store'])->name('admin.themnickmoi.store');
    Route::get('/sua-nick/{id}', [App\Http\Controllers\Admin\AccountController::class, 'edit'])->name('admin.suanick');
    Route::put('/sua-nick/{id}', [App\Http\Controllers\Admin\AccountController::class, 'update'])->name('admin.suanick.update');
    Route::get('/game/{id}/attributes', [App\Http\Controllers\Admin\AccountController::class, 'getGameAttributes'])->name('admin.game.attributes');
    Route::get('/game/{id}/categories', [App\Http\Controllers\Admin\AccountController::class, 'getGameCategories'])->name('admin.game.categories');

    Route::get('/ho-tro-phong-ve', function () {
        return view('admin.pages.hotrophongve');
    })->name('admin.hotrophongve');

    Route::get('/vong-quay-may-man', function () {
        return view('admin.pages.vongquaymayman');
    })->name('admin.vongquaymayman');

    Route::get('/tin-tuc-su-kien', function () {
        return view('admin.pages.tintucsukien');
    })->name('admin.tintucsukien');
});

