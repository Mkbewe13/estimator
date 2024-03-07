<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($quotations->isEmpty())
                <x-est-empty-list-block name="There are no estimations, go ahead and create first one!" url="{{route('quotation_data.form',1)}}" />
            @else
            @foreach($quotations as $quotation )
                    <x-est-list-item :id="$quotation->id" :name="$quotation->name" :status="$quotation->status" :url="null"/>
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
