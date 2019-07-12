<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

/**
 * Class PaymentSubscription.
 */
class PaymentSubscription
{
    /**
     * @param         $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();
        
        if (config('access.payment_subscription')) {
            if($user->user_subscription_id && $user->subscription_expiry_date && strtotime($user->subscription_expiry_date." 23:59:59") > time() ) {
               return $next($request);
            }else{
                return redirect()->route('frontend.user.settings');
            }
        }

        return $next($request);
    }
}
