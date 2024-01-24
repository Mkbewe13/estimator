<?php

namespace App\Http\Controllers;

use App\Jobs\QuotationJob;
use App\Models\QuotationData;
use App\Services\QuotationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuotationDataController extends Controller
{


    public function form(): View
    {
        return view('estimator.store');
    }


    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([

            'name' => 'required|string',
            'description' => 'required|string',
            'userflow' => 'required|string',
            'requirements' => 'required|string',

        ]);

        $quotationData = new QuotationData();
        $quotationData->name = $validated['name'];
        $quotationData->description = $validated['description'];
        $quotationData->userflow = $validated['userflow'];
        $quotationData->requirements = $validated['requirements'];
        $quotationData->save();

        return redirect(route('index'));
    }


    public function index(){
        $quotations = QuotationData::all();

        if(($quotations->isEmpty())){
            $quotations = null;
        }

        return view('estimator.index',[
            'quotations' => $quotations
        ]);
    }

    public function show($id){
        $quotation = QuotationData::find($id);
        return view('estimator.show',['quotation' => $quotation]);
    }
    public function edit(int $id){

        $quotation = QuotationData::find($id);
        return view('estimator.edit',['quotation' => $quotation]);
    }


    public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required|int',
            'name' => 'required|string',
            'description' => 'required|string',
            'userflow' => 'required|string',
            'requirements' => 'required|string',

        ]);
        $quotationData = QuotationData::find($validated['id']);
        $quotationData->name = $validated['name'];
        $quotationData->description = $validated['description'];
        $quotationData->userflow = $validated['userflow'];
        $quotationData->requirements = $validated['requirements'];
        $quotationData->save();
        return view('estimator.show',['quotation' => $quotationData]);
    }

    public function send(Request $request){

        $validated = $request->validate([
            'id' => 'required|int',
        ]);

        $quotationData = QuotationData::find($validated['id']);

        QuotationJob::dispatch($quotationData->id);

        $quotationData->status = 'in_progress';
        $quotationData->save();

        return view('estimator.show',['quotation' => $quotationData]);
    }


}
