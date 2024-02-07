<x-app-layout>

    <div class="container-fluid ml-md-3 mr-md-3">
        <div class="row">
            <div class="bg-gray-300 col-12 col-md-2 order-1 order-md-2 justify-center rounded-md border border-gray-400 shadow">
                <x-est-form-rows-list-info></x-est-form-rows-list-info>
            </div>
            <div class="col-12 col-md-10 order-2 order-md-1 max-w-7xl mx-auto p-4 sm:p-6 lg:p-8" >
                @switch(1)
                    @case(1)
                        @include('quotation_data/partials/create_step_1')
                        @break
                    @case(2)
                        @include('quotation_data/partials/create_step_2')
                        @break
                    @case(3)
                        @include('quotation_data/partials/create_step_3')
                        @break
                @endswitch
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn create-form-button">Next</button>
                    </div>
            </div>
        </div>

    </div>

</x-app-layout>
