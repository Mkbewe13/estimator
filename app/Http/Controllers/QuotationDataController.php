<?php

namespace App\Http\Controllers;

use App\Enums\QuotationStatus;
use App\Jobs\QuotationJob;
use App\Jobs\VerifyQuotationDataJob;
use App\Models\QuotationData;
use App\Services\QuotationService;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuotationDataController extends Controller
{


    /**
     * Displays form for creating new Estimation(QuotationData) object
     *
     * @return View
     */
    public function form(int $step = 1): View
    {
        session(['step' => $step]);

        $id = session('qid');

        $quotationData = QuotationData::findOr($id,function (){
            return null;
        }
        );


        return view('quotation_data.create', compact('step', 'quotationData'));
    }

    /**
     * Displays form for creating new Estimation(QuotationData) object
     *
     * @return View
     */
    public function edit(Request $request): View
    {
        $requestData = $request->validate([
            'id' => 'required|int',
            'step' => 'required|int',
        ]);

        session(['qid' => $requestData['id']]);
       return $this->form($requestData['step']);
    }

    public function verify(Request $request){
        $requestData = $request->validate([
            'id' => 'required|int'
        ]);

        $quotationData = QuotationData::find($requestData['id']);

        if(!$quotationData){
            return redirect()->route('quotation_data.index');
        }

        $quotationData->status = QuotationStatus::ACCEPTATION_IN_PROGRESS->value;
        $quotationData->save();

        VerifyQuotationDataJob::dispatch($quotationData->id);

        return redirect()->route('quotation_data.index');
    }


    /**
     * Handles creating new Estimation(QuotationData) object.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        if(!session()->has('step') || !in_array( session('step'), [1,2,3]) ){
            return redirect()->route('quotation_data.index');
        }

        $step = session('step',1);

        if($request->has('next') || $request->has('save')){
            $formData = $this->processFormStepData($step, $request);
        }else
        {

            return back();
        }

        if ($step == 1 && !session()->has('qid')  ) {
            $formData['status'] = QuotationStatus::PREPARING->value;
            $quotationData = QuotationData::create($formData);
            $quotationDataId = $quotationData->id;
            session(['qid' => $quotationDataId]);
        } else {
            if(!session()->has('qid') ){
                throw new Exception('QuotationId is missing');
            }

            $quotationDataId = session('qid');
            $quotationData = QuotationData::find($quotationDataId);

            if (!$quotationData) {
                throw new Exception('Estimate not found by ID');
            }
            if($step == 3){
            $formData['status'] = QuotationStatus::WAITING_FOR_ACCEPT->value;
            }
            $quotationData->update($formData);

        }

        return $this->handleFormRedirection((int)$step,$quotationDataId);


    }


    /**
     * Displays all estimations.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        session()->forget('qid');
        session()->forget('step');
        $quotations = QuotationData::paginate('10');

        return view('quotation_data.index', [
            'quotations' => $quotations
        ]);
    }

    /**
     * Displays single estimation.
     *
     * @param $id
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws Exception
     */
    public function show($id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|Factory|Application
    {
        $quotationData = QuotationData::find($id);

        if(!$quotationData){
            throw new Exception('Estimate not found by ID');
        }

        return view('quotation_data.show', ['quotation' => $quotationData]);
    }

    public function delete(Request $request): RedirectResponse
    {

        $requestData = $request->validate([
            'id' => 'required|int',
        ]);

        $quotationData = QuotationData::find($requestData['id']);

        if(!$quotationData){
            throw new Exception('Estimate not found by ID');
        }

        $quotationData->delete();

        return redirect()->route('quotation_data.index');
    }


    /**
     * Handles update of QuotationData object.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws Exception
     */
    public function update(Request $request): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|Factory|Application
    {
        $validated = $request->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'description' => 'required|string',
            'userflow' => 'required|string',
            'requirements' => 'required|string',
        ]);

        $quotationData = QuotationData::find($validated['id']);

        if(!$quotationData){
            throw new Exception('Estimate not found by ID');
        }

        $quotationData->update($validated);
        return view('quotation_data.show', ['quotation' => $quotationData]);
    }

    /**
     * Dispatches job with estimation generation to queue.
     *
     * @param Request $request
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     * @throws Exception
     */
    public function dispatch(Request $request): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|Factory|Application
    {

        $validated = $request->validate([
            'id' => 'required|int',
        ]);

        $quotationData = QuotationData::find($validated['id']);

        if(!$quotationData){
            throw new Exception('Estimate not found by ID');
        }

        $quotationData->status = QuotationStatus::ESTIMATION_IN_PROGRESS->value;
        $quotationData->save();

        QuotationJob::dispatch($quotationData->id);

        return view('quotation_data.show', ['quotation' => $quotationData]);
    }


    private function processFormStepData(int $step, Request $request){

        $textFieldValidationRule = 'string|nullable';
        $textFieldRequiredValidationRule = 'required|string';
        switch ($step) {
            case 1:
                $requestData = $request->validate([
                        'name' => $textFieldRequiredValidationRule,
                        'objectives' => $textFieldRequiredValidationRule,
                        'features' => $textFieldRequiredValidationRule,
                    ]
                );
                break;
            case 2:
                $requestData = $request->validate([
                    'roles' => $textFieldValidationRule,
                    'integrations' => $textFieldValidationRule,
                    'db' => $textFieldValidationRule,
                    'design' => $textFieldValidationRule,
                ]);
                break;

            case 3:
                $requestData = $request->validate([
                    'deploy' => $textFieldValidationRule,
                    'scalability' => $textFieldValidationRule,
                    'maintenance' => $textFieldValidationRule,
                    'tech' => $textFieldValidationRule,
                ]);
                break;
            default:
                throw new Exception('Wrong from step in processing');
        }

        return $requestData;

    }

    private function handleFormRedirection(int $step,?int $quotationDataId): RedirectResponse
    {       //@todo
        //obsługa edycji po rejectcie
        //testy weryfikacji => widok podglądu => logika uruchamiania estymacji => estymowanie
        //logika uruchamiania estymacji - jakaś forma wybierania szczegółow estymacji jnior/mid/senior czy bufor na spotkania czy testy jednostkowe
        //


        // - nawigacja w formie na liscie pytan
        //oznaczanie jako niepotrzebnych w formularzu? żeby user wiedział że może zostawić puste.

        $nextStep = $step + 1;
        switch ($step) {
            case 3:
                session()->forget('step');
                session()->forget('qid');
                return redirect()->route('quotation_data.index');
            case 1:
            case 2:
                session('step', $nextStep);
                return redirect()->route('quotation_data.form',['step' => $nextStep]);
            default:
                throw new Exception('Wrong from step in processing');
        }

    }

}
