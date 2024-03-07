<x-app-layout>
    <div class="sm:max-w-xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


            <div class="p-6 text-gray-900">


                <div style="display: flex; justify-content: space-between">

                    <p>Name: </p>
                    <b>{{$quotation->name}}</b>
                    @if($quotation->status == \App\Enums\QuotationStatus::PREPARING->value)
                        <x-primary-button style="display: flex" type="button"
                                          onclick="window.location='{{ route('quotation_data.edit',['id' => $quotation->id]) }}'">
                            Edit
                        </x-primary-button>
                    @endif
                    <x-primary-button style="display: flex;color: darkred" type="button"
                                      onclick="window.location='{{ route('quotation_data.delete',['id' => $quotation->id]) }}'">
                        Delete
                    </x-primary-button>
                </div>
            </div>

        </div>
        <br>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                @if($quotation->status == \App\Enums\QuotationStatus::DONE->value)
                    <div style="display: flex; justify-content: space-between">
                        <p>Frontend estimation:</p>
                        <form method="POST" action="{{ route('xlsx.download') }}">
                            @csrf
                            <input type="hidden" name="id" value={{$quotation->id}}>
                            <input type="hidden" name="projectSide" value="frontend">
                            <div style="text-align: center">
                                <x-primary-button>Download</x-primary-button>
                            </div>

                        </form>

                    </div>
                    <br>
                    <div style="display: flex; justify-content: space-between">
                        <a>Backend estimation:</a>
                        <form method="POST" action="{{ route('xlsx.download') }}">
                            @csrf
                            <input type="hidden" name="id" value={{$quotation->id}}>
                            <input type="hidden" name="projectSide" value="backend">
                            <div style="text-align: center">
                                <x-primary-button>Download</x-primary-button>
                            </div>

                        </form>

                    </div>
                @elseif($quotation->status == \App\Enums\QuotationStatus::ESTIMATION_IN_PROGRESS->value)
                    <div style="text-align: center;color: darkorange">
                        <p>Processing...</p>

                    </div>
                @else
                    <form method="POST" action="{{ route('quotation_data.dispatch') }}">
                        @csrf
                        <input type="hidden" name="id" value={{$quotation->id}}>
                        <div style="text-align: center">
                            <x-primary-button>Run estimation</x-primary-button>
                        </div>

                    </form>

                @endif
            </div>


        </div>

    </div>
    <div class="sm:max-w-xl mx-auto p-4 sm:p-6 lg:p-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div style="display: flex; justify-content: space-between">
                    <p>Application description:</p>
                    <form method="POST" action="{{ route('docx.download') }}">
                        @csrf
                        <input type="hidden" name="id" value={{$quotation->id}}>
                        <div style="text-align: center">
                            <x-primary-button>Download .docx</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="max-w-5xl mx-auto p-4 sm:p-6 lg:p-8">

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


            <div class="p-6 text-gray-900">


                <div>

                    <b>Description:</b>
                    <p style="white-space: pre-wrap;">{!! $quotation->description !!}</p>
                </div>
            </div>

        </div>
        <br>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


            <div class="p-6 text-gray-900">


                <b>Userflow:</b>
                <p style="white-space: pre-wrap;">{!!  $quotation->userflow!!}</p>
            </div>

        </div>
        <br>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">


            <div class="p-6 text-gray-900">

                <b>Requirements:</b>
                <p style="white-space: pre-wrap;">{!!$quotation->requirements!!}</p>
            </div>

        </div>
        <br>

    </div>

</x-app-layout>
