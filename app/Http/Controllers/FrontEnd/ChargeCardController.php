<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\BasicHelper;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Informatics\Base\Models\ChargeCardHistory;
use Validator;
use View;
use App\Services\chargeCardService;
use Log;

class ChargeCardController extends BaseController
{
    protected $chargeCard;

    public function __construct(chargeCardService $chargeCard)
    {
        parent::__construct();
        $this->chargeCard = $chargeCard;
    }

    public function index()
    {
        $this->setUp();
        return view('frontend.charge_card.index');
    }

    public function chargeCardComplete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'captcha' => 'required|captcha',
        ], []);

        if ($validator->fails()) {
            return redirect('nap-the')->with('error_message', $validator->errors()->first());
        }

        if ($request['amount'] < 50000) {
            $request['telco'] = $request['telco'] . '2';
        }

        $user = BasicHelper::getUserDetails();
        $validator = $this->chargeCard->ValidateCard($request['telco'], $request['serial'], $request['pin']);
        if (!is_bool($validator)) {
            return redirect('nap-the')->with('error_message', $validator);
        }

        $cardData = [
            'user_id'   => $user->id,
            'amount1'   => $request['amount'],
            'card_type' => $request['telco'],
            'serial'    => $request['serial'],
            'pin'       => $request['pin'],
            'status'    => 2, // waiting
        ];

        try {
            $chargeCardHistory = ChargeCardHistory::create($cardData);
            if ($chargeCardHistory) {
                $result = $this->chargeCard->ChargeCard($request['telco'], $request['serial'], $request['pin'], $request['amount'], $user->id);
                if (!isset($result->status)) {
                    $updateCard = ChargeCardHistory::where('id', $chargeCardHistory['id'])->limit(1)->update(['status' => 0, 'desc' => $result]);
                    if ($updateCard) {
                        return redirect('nap-the')->with('error_message', $result);
                    }
                }
                if ($result->card_data != null) {
                    //Xử lý thẻ được duyệt tự động
//                    $resultData = [
//                        'is_auto_process' => 1,
//                        'id_trumthe'      => $result->card_data->id,
//                        'amount2'         => $result->card_data->amount,
//                        'real_amount'     => $result->card_data->real_amount,
//                        'status'          => 1, // success
//                        'fix_amount'      => 0, // nếu thẻ gạch úng mệnh giá
//                        'charge_time'     => Carbon::now()->format('H:i:s d/m/Y'),
//                    ];
//                    $updateCard = ChargeCardHistory::where('id', $chargeCardHistory['id'])->limit(1)->update($resultData);
//                    if ($updateCard) {
//                        // cộng tiền cho người dùng
//                        $remainingAmount = $user->amount + $result->card_data->amount;
//                        $updateUser = User::where('id', $chargeCardHistory['user_id'])->update(['amount' => $remainingAmount]);
//                        if($updateUser){
//                            return redirect('nap-the')->with('message', 'Nạp thẻ thành công !');
//                        }
//                    }
                } else {
                    Log::info('Người dùng nạp thẻ thành công, thẻ cào đang được xử lý !', array('ItemID' => $user->id, 'Module' => 'Users'));
                    return redirect('nap-the')->with('message', 'Nạp thẻ thành công, thẻ cào đang được xử lý !');
                }
            }
        } catch (\Exception $ex) {
            return redirect('nap-the')->with('error_message', $ex->getMessage());
        }

    }

    public function setUp()
    {
        $card_type = [
            'VTT' => 'Viettel',
            'VMS' => 'Mobifone',
            'VNP' => 'Vinaphone',
        ];

        $amounts = [
            '10000'   => '10,000 VNĐ',
            '20000'   => '20,000 VNĐ',
            '30000'   => '30,000 VNĐ',
            '50000'   => '50,000 VNĐ',
            '100000'  => '100,000 VNĐ',
            '200000'  => '200,000 VNĐ',
            '300000'  => '300,000 VNĐ',
            '500000'  => '500,000 VNĐ',
            '1000000' => '1,000,000 VNĐ',
        ];
        View::share('amounts', $amounts);
        View::share('card_type', $card_type);
    }
}