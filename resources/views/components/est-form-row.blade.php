<div class="form-group form-row-component mb-5">
    <label class="form-control-md" for="{{ $id }}">{{$ordinalNumber .'. '}}{{ $label }}</label>
    <div class="{{$colWidthClass}}">
        <textarea class="form-control rounded shadow-md" id="{{ $id }}" rows="{{$textAreaRows}}"></textarea>
    </div>
</div>
