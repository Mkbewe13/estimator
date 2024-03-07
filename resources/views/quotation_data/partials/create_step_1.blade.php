<x-est-form-row ordinalNumber="0" name='name' id="name" label="Name" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"  size="{{\App\Enums\EstFormRowSize::SMALL}}" />
<x-est-form-row ordinalNumber="1"  name='objectives'  id="objectives"  label="Project Goals and Objectives"
                quotationDataId="{{$quotationData ? $quotationData->id : 0}}" size="{{\App\Enums\EstFormRowSize::LARGE}}" />
<x-est-form-row ordinalNumber="2"  name='features'  id="features"  label="Features List"
                quotationDataId="{{$quotationData ? $quotationData->id : 0}}" size="{{\App\Enums\EstFormRowSize::LARGE}}" />
