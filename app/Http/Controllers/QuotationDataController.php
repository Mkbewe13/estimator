<?php

namespace App\Http\Controllers;

use App\Enums\QuotationStatus;
use App\Jobs\QuotationJob;
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
    public function form(): View
    {
        return view('estimator.store');
    }


    /**
     * Handles creating new Estimation(QuotationData) object.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'userflow' => 'required|string',
            'requirements' => 'required|string',
        ]);

        QuotationData::create($validated);

        return redirect(route('index'));
    }


    /**
     * Displays all estimations.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $quotations = QuotationData::paginate('10');

        return view('estimator.index', [
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

        return view('estimator.show', ['quotation' => $quotationData]);
    }

    public function delete($id): RedirectResponse
    {
        $quotationData = QuotationData::find($id);

        if(!$quotationData){
            throw new Exception('Estimate not found by ID');
        }

        $quotationData->delete();

        return redirect()->route('index');
    }

    /**
     * Displays form for editing QuotationData object.
     *
     * @param int $id
     * @return \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|Factory|Application
     * @throws Exception
     */
    public function edit(int $id): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|Factory|Application
    {
        $quotationData = QuotationData::find($id);

        if(!$quotationData){
            throw new Exception('Estimate not found by ID');
        }
        return view('estimator.edit', ['quotation' => $quotationData]);
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
        return view('estimator.show', ['quotation' => $quotationData]);
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

        $quotationData->status = QuotationStatus::IN_PROGRESS->value;
        $quotationData->save();

        QuotationJob::dispatch($quotationData->id);

        return view('estimator.show', ['quotation' => $quotationData]);
    }


}
