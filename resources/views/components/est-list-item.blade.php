<div
    class=" container bg-white   border sm:rounded-lg shadow-sm p-4 mb-2">
    <div class="row justify-items-center">

        <div class="col d-flex align-items-center">
            <b class="">{{ $name }}</b>
        </div>

        <div class="col d-md-flex align-items-center d-sm-block text-center mt-3 mt-md-0">
            Status:
            <span data-toggle="tooltip" title="{{\App\Enums\QuotationStatus::getStatusDescription($status)}}" class="ml-md-1 d-block d-md-inline {{$displayCssClass}}"> {{ $displayStatus }}</span>
        </div>


        <div class="col col-4  justify-end d-sm-block d-md-flex">
            @switch($status)
                @case(\App\Enums\QuotationStatus::PREPARING->value)
                @case(\App\Enums\QuotationStatus::REJECTED->value)
                    <form method="post" action="{{route('quotation_data.edit')}}" >
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="step" value="1">
                        <button type="submit" class="btn btn-primary list-item-button">Edit</button>
                    </form>
                    @break
                @case(\App\Enums\QuotationStatus::WAITING_FOR_ACCEPT->value)

                    <form class="mb-2 mb-md-0 d-sm-block text-center"  method="post" action="{{route('quotation_data.edit')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="step" value="1">
                        <button type="submit" class="btn btn-primary list-item-button">Edit</button>
                    </form>
                    <form class="mb-2 mb-md-0 d-sm-block text-center"  method="post" action="{{route('quotation_data.verify')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <button type="submit" class="btn btn-primary list-item-button">Verify</button>
                    </form>

                    @break
                @case(\App\Enums\QuotationStatus::ACCEPTATION_IN_PROGRESS->value)
                    <button disabled class="btn btn-primary list-item-button">Verifying...</button>
                    @break
                @case(\App\Enums\QuotationStatus::ESTIMATION_IN_PROGRESS->value)
                    <button disabled class="btn btn-primary list-item-button">Estimating...</button>
                    @break
                @default
                    <a class="btn  btn-primary list-item-button" href="{{$url}}">Show</a>
                    @break
            @endswitch

                    <form class=" d-sm-block text-center" method="post" action="{{route('quotation_data.delete')}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$id}}">
                        <input type="hidden" name="step" value="1">
                        <button type="submit" class="btn btn-outline-danger " onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                    </form>

</div>

    </div>
    </div>

@push('scripts')
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@endpush
