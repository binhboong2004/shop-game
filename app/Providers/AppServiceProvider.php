<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Game;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('clients.partials.header', function ($view) {
            $view->with('games', Game::with(['gameCategories' => function ($query) {
                $query->where('status', 1);
            }, 'luckyWheels' => function ($query) {
                $query->where('status', 1);
            }])->where('status', 1)->get());
        });

        View::composer('admin.partials.sidebar', function ($view) {
            $pendingAccountsCount = \App\Models\Account::where('status', 'pending_approval')->count();
            $pendingDepositsCount = \App\Models\Deposit::where('status', 'pending')->count();
            $pendingWithdrawalsCount = \App\Models\Withdrawal::where('status', 'pending')->count();
            $view->with([
                'pendingAccountsCount' => $pendingAccountsCount,
                'pendingDepositsCount' => $pendingDepositsCount,
                'pendingWithdrawalsCount' => $pendingWithdrawalsCount
            ]);
        });

        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Xác thực địa chỉ Email của bạn - ShopNickVN')
                ->line('Cảm ơn bạn đã đăng ký tài khoản tại hệ thống của chúng tôi.')
                ->line('Vui lòng click vào nút bên dưới để xác thực địa chỉ email của bạn.')
                ->action('Xác Thực Email', $url)
                ->line('Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.');
        });
    }
}
