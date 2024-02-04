
<div class="bg-white d-flex flex-column flex-md-row justify-content-between align-items-center border sm:rounded-lg shadow-sm p-4 mb-2">
    <div>
        <h5>{{ $name }}</h5>
    </div>
    <div class="d-flex flex-column flex-md-row ml-md-auto mt-4 mt-md-0">
    <div class="w-48 w-md-auto list-item-status">
        <b>Status:</b><span class="{{$displayCssClass}}"> {{ $status }}</span>
    </div>
    <div class="text-center text-md-left ml-md-5 mt-4 mt-md-0" >
        <a class="btn btn-primary list-item-button"  href="{{$url}}">Show estimation</a>
    </div>
    </div>
</div>
