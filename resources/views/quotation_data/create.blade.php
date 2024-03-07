<x-app-layout>
    <div class="container-fluid ml-md-3 mr-md-3">
        <div class="row">
            <div class="bg-gray-300 col-12 col-md-2 order-1 order-md-2 justify-center rounded-md border border-gray-400 shadow">
                <x-est-form-rows-list-info step="{{$step}}" quotationDataId="{{$quotationData ? $quotationData->id : null}}" ></x-est-form-rows-list-info>
            </div>
            <div class="col-12 col-md-10 order-2 order-md-1 max-w-7xl mx-auto p-4 sm:p-6 lg:p-8" >
                <form method="post" action="{{ route('quotation_data.store') }}">
                    @csrf
                    @switch($step)
                        @case(1)
                            @include('quotation_data/partials/create_step_1',['quotationData' => $quotationData])
                            @break
                        @case(2)
                            @include('quotation_data/partials/create_step_2',['quotationData' => $quotationData])
                            @break
                        @case(3)
                            @include('quotation_data/partials/create_step_3',['quotationData' => $quotationData])
                            @break
                    @endswitch
                    @if($step == 3)
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" name='save' class="btn create-form-button">{{$quotationData->status == \App\Enums\QuotationStatus::REJECTED->value ?"Save Corrected Estimation Data" :"Save Estimation Data"}}</button>
                        </div>
                    @else
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" name='next' class="btn create-form-button">Next</button>
                        </div>
                    @endif

                </form>
            </div>
        </div>

    </div>

</x-app-layout>
