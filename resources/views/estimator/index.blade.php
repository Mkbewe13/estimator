<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($quotations == null)

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                    <div class="p-6 text-gray-900">
                        <div style="display: flex; justify-content: space-between">
                            <p>There are no estimations, go ahead and create one :)</p>
                            <x-primary-button style="display: flex"  type="button" style="margin-right: 40px;" onclick="window.location='{{ route('estimations.store') }}'">Create estimation</x-primary-button>
                        </div>
                    </div>

                </div>

            @else



            @foreach($quotations as $quotation )

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


                <div class="p-6 text-gray-900">


                    <div style="display: flex; justify-content: space-between">

                    <a href="{{route('estimations.show',['id' => $quotation->id])}}">{{ $quotation->name}}</a>

                        <div style="display: flex">
                                <b style="margin-top: 5px;margin-right: 10px;" >Status: </b>
                            @if($quotation->status == 'new')
                                <p style="margin-top: 5px;margin-right: 80px;text-align: center;color: darkblue">New</p>
                            @elseif($quotation->status == 'in_progress')
                                <p style="margin-top: 5px;margin-right: 80px;text-align: center;color: darkorange">Processing...</p>
                            @else
                                <p style="margin-top: 5px;margin-right: 80px;text-align: center;color: darkgreen">Ready to download</p>
                            @endif


                    <x-primary-button   type="button" style="margin-right: 40px;" onclick="window.location='{{ route('estimations.show',['id' => $quotation->id]) }}'">Enter estimation</x-primary-button>
                        </div>

                    </div>

                </div>

            </div>
                <br>
            @endforeach
            @endif
        </div>
    </div>
</x-app-layout>
