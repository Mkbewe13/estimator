<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($quotations->isEmpty())
{{--                @TODO dodać component pusta lista--}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                    <div class="p-6 text-gray-900">
                        <div style="display: flex; justify-content: space-between">
                            <p>There are no estimations, go ahead and create one :)</p>
                            <x-primary-button style="display: flex"  type="button" style="margin-right: 40px;" onclick="window.location='{{ route('quotation_data.store') }}'">Create estimation</x-primary-button>
                        </div>
                    </div>

                </div>

            @else
            @foreach($quotations as $quotation )
                    <x-est-list-item :name="$quotation->name" :status="$quotation->status" :url="route('quotation_data.show',['id' => $quotation->id]) "/>
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
