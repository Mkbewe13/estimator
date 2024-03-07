<x-est-form-row ordinalNumber="7" name='deploy' id="deploy" label="Deployment Environment" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                 size={{\App\Enums\EstFormRowSize::LARGE}} />
<x-est-form-row ordinalNumber="8" name='scalability' id="scalability" label="Scalability and Performance Requirements" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                 size={{\App\Enums\EstFormRowSize::LARGE}}/>
<x-est-form-row ordinalNumber="9" name='maintenance' id="maintenance" label="Maintenance and Update Plans" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                 size={{\App\Enums\EstFormRowSize::LARGE}} />
<x-est-form-row ordinalNumber="10" name='tech' id="tech" label="Tools and Technologies Preferences" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                 size={{\App\Enums\EstFormRowSize::LARGE}} />


