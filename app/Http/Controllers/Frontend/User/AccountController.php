<?php

namespace App\Http\Controllers\Frontend\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Interest\Interest;
use App\Models\Subscription\Subscription;
use App\Models\Auth\User;
use App\Models\Settings\Settings;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;
use App\Repositories\Backend\UserSubscription\UserSubscriptionRepository;
use App\Models\Country\Country;

define("AUTHORIZENET_LOG_FILE", "phplog");

/**
 * Class AccountController.
 */
class AccountController extends Controller
{
	protected $userSubscriptionRepository;

	/**
	 * ProfileController constructor.
	 *
	 * @param UserSubscriptionRepository $userSubscriptionRepository
	 */
	public function __construct(UserSubscriptionRepository $userSubscriptionRepository)
	{
		$this->userSubscriptionRepository = $userSubscriptionRepository;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request)
	{
            // Check subscription
            if(auth()->user()->is_subscribed == 0){
                return redirect()->route('frontend.user.settings')->withFlashError('Your subscription has been expire.');
            }
		return view('frontend.user.account')
			->withInterest(Interest::where("user_id", '=', auth()->user()->id)->get())
			->withCountries(Country::where('status','1')->pluck('nicename','id')->all())->withRequest($request);
	}

	public function settings(Request $request)
	{
		$subscriptions = Subscription::where('status', '1')->get();
		$user = auth()->user();

		$setting = Settings::all();
		$settings = array();
		foreach ($setting as $setting_data) {
			$settings[$setting_data->setting_key] = $setting_data->setting_value;
		}

		return view('frontend.user.settings', compact('subscriptions'), compact('settings'))->withRequest($request);
	}

	public function changeStatus(Request $request)
	{
		$data = $request->all();
		$response = User::where('id', auth()->user()->id)
			->update([
				$data['type'] => ($data['value'] == 'true') ? '1' : '0',
			]);
		return $response;
	}

	function createAnAcceptPaymentTransaction(Request $request)
	{
		$data = $request->all();
		$this->validate($request, [
			'plan' => 'required',
		],
		[	
			'plan.required' => 'Subscription plan is required'
		]);

		$subscription_data = Subscription::find($data['plan']);

		$setting = Settings::all();
		$settings = array();
		foreach ($setting as $setting_data) {
			$settings[$setting_data->setting_key] = $setting_data->setting_value;
		}

		$amount = $subscription_data->price;
	
    /* Create a merchantAuthenticationType object with authentication details
       retrieved from the constants file */
		$merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
		$merchantAuthentication->setName($settings['payment_login_id']);
		$merchantAuthentication->setTransactionKey($settings['payment_transaction_key']);
    
    // Set the transaction's refId
		$refId = 'ref' . time();

    // Create the payment object for a payment nonce
		$opaqueData = new AnetAPI\OpaqueDataType();
		$opaqueData->setDataDescriptor($data['dataDescriptor']);
		$opaqueData->setDataValue($data['dataValue']);


    // Add the payment data to a paymentType object
		$paymentOne = new AnetAPI\PaymentType();
		$paymentOne->setOpaqueData($opaqueData);

    // Create a TransactionRequestType object and add the previous objects to it
		$transactionRequestType = new AnetAPI\TransactionRequestType();
		$transactionRequestType->setTransactionType("authCaptureTransaction");
		$transactionRequestType->setAmount($amount);
		$transactionRequestType->setPayment($paymentOne);
    

    // Assemble the complete transaction request
		$request = new AnetAPI\CreateTransactionRequest();
		$request->setMerchantAuthentication($merchantAuthentication);
		$request->setRefId($refId);
		$request->setTransactionRequest($transactionRequestType);

    // Create the controller and get the response
		$controller = new AnetController\CreateTransactionController($request);
		$response = $controller->executeWithApiResponse(\net\authorize\api\constants\ANetEnvironment::SANDBOX);


		if ($response != null) {
        // Check to see if the API request was successfully received and acted upon
			if ($response->getMessages()->getResultCode() == "Ok") {
            // Since the API request was successful, look for a transaction response
            // and parse it to display the results of authorizing the card
				$tresponse = $response->getTransactionResponse();

				if ($tresponse != null && $tresponse->getMessages() != null) {
                // echo " Successfully created transaction with Transaction ID: " . $tresponse->getTransId() . "\n";
                // echo " Transaction Response Code: " . $tresponse->getResponseCode() . "\n";
                // echo " Message Code: " . $tresponse->getMessages()[0]->getCode() . "\n";
                // echo " Auth Code: " . $tresponse->getAuthCode() . "\n";
				// echo " Description: " . $tresponse->getMessages()[0]->getDescription() . "\n";

					$user_data = array(
						'user_id' => auth()->user()->id,
						'subscription_id' => $data['plan'],
						'transaction_id' => $tresponse->getTransId(),
						'payment_method' => 'authorizeDotNet:card',
						'payment_amount' => $amount,
						'payment_ref_no' => $refId,
						'payment_response' => $tresponse->getMessages()[0]->getDescription(),
						'payment_status' => 'success',
						'payment_date' => date('Y-m-d H:i:s'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$subscription = $this->userSubscriptionRepository->create($user_data);


					$user = User::where('id', auth()->user()->id)
						->update([
                                                        'is_subscribed' => 1,
							'user_subscription_id' => $subscription->id,
							'subscription_expiry_date' => date('Y-m-d', strtotime('+1 years'))
						]);
					return redirect()->route('frontend.user.settings')->withFlashSuccess(__('Payment has been done successfully!'));
				} else {
                // echo "Transaction Failed \n";
					if ($tresponse->getErrors() != null) {
                    // echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
					// echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
						$user_data = array(
							'user_id' => auth()->user()->id,
							'subscription_id' => $data['plan'],
							'transaction_id' => 0,
							'payment_method' => 'authorizeDotNet:card',
							'payment_amount' => $amount,
							'payment_ref_no' => $refId,
							'payment_response' => $tresponse->getErrors()[0]->getErrorText(),
							'payment_status' => 'fail',
							'payment_date' => date('Y-m-d H:i:s'),
							'created_at' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
						);
						$subscription = $this->userSubscriptionRepository->create($user_data);
					}
				}
            // Or, print errors if the API request wasn't successful
			} else {
            // echo "Transaction Failed \n";
				$tresponse = $response->getTransactionResponse();

				if ($tresponse != null && $tresponse->getErrors() != null) {
                // echo " Error Code  : " . $tresponse->getErrors()[0]->getErrorCode() . "\n";
				// echo " Error Message : " . $tresponse->getErrors()[0]->getErrorText() . "\n";
					$user_data = array(
						'user_id' => auth()->user()->id,
						'subscription_id' => $data['plan'],
						'transaction_id' => 0,
						'payment_method' => 'authorizeDotNet:card',
						'payment_amount' => $amount,
						'payment_ref_no' => $refId,
						'payment_response' => $tresponse->getErrors()[0]->getErrorText(),
						'payment_status' => 'fail',
						'payment_date' => date('Y-m-d H:i:s'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$subscription = $this->userSubscriptionRepository->create($user_data);
				} else {
                // echo " Error Code  : " . $response->getMessages()->getMessage()[0]->getCode() . "\n";
				// echo " Error Message : " . $response->getMessages()->getMessage()[0]->getText() . "\n";
					$user_data = array(
						'user_id' => auth()->user()->id,
						'subscription_id' => $data['plan'],
						'transaction_id' => 0,
						'payment_method' => 'authorizeDotNet:card',
						'payment_amount' => $amount,
						'payment_ref_no' => $refId,
						'payment_response' => $response->getMessages()->getMessage()[0]->getText(),
						'payment_status' => 'fail',
						'payment_date' => date('Y-m-d H:i:s'),
						'created_at' => date('Y-m-d H:i:s'),
						'updated_at' => date('Y-m-d H:i:s'),
					);
					$subscription = $this->userSubscriptionRepository->create($user_data);
				}
			}
		} else {
        // echo  "No response returned \n";
		}

		return redirect()->route('frontend.user.settings')->withFlashInfo(__('Error Occured!'));
	}
        
        
        function check_subscription(){
//            echo auth()->user()->id; exit;
            if(auth()->user()->id != 1){
                $user_details = User::select(['subscription_expiry_date'])->where('id', auth()->user()->id)->first();
                
                if(strtotime($user_details->subscription_expiry_date) < strtotime(date('Y-m-d'))){
                    $user = User::where('id', auth()->user()->id)
                                ->update(['is_subscribed' => 0]);
                }else{
                    echo FALSE;
                }
            }else{
                echo FALSE;
            }
            exit;
        }

}
