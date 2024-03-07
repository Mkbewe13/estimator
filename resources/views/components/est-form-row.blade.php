<div class="form-group form-row-component mb-5">

    <label
        @if(!$isVerified)
            class="form-control-md form-row-label-rejected" data-toggle="tooltip" title="{{$rejectedVerificationMessage}}" for="{{ $id }}">{{$ordinalNumber+1 .'. '}}{{ $label }}
        @else
            class="form-control-md" for="{{ $id }}">{{$ordinalNumber+1 .'. '}}{{ $label }}
        @endif
    </label>

    <div class="{{$colWidthClass}}">
        <textarea class="form-control rounded shadow-md" name="{{ $name }}" id="{{ $id }}" rows="{{$textAreaRows}}" >{{$value}}</textarea>
    </div>
</div>
