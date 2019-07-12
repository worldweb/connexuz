<?php

namespace App\Http\Controllers\Frontend\Help;

use App\Http\Controllers\Controller;
use App\Models\Faq\Faq;
use Illuminate\Http\Request;

/**
 * Class ContactController.
 */
class HelpController extends Controller {

    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request) {

        // Check subscription
        if (auth()->user()->is_subscribed == 0) {
            return redirect()->route('frontend.user.settings')->withFlashError('Your subscription has been expire.');
        }

        $help = Faq::where('status', '1')->get();
        return view('frontend.help.index')
                        ->withFaqs($help)->withRequest($request);
    }

}
