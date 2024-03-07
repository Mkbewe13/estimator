
<x-est-form-row ordinalNumber="3" name='roles' id="roles" label="User Roles and Permissions" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                 size="{{\App\Enums\EstFormRowSize::LARGE}}" />
<x-est-form-row ordinalNumber="4" name='integrations' id="integrations" label="Integration Points" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                 size={{\App\Enums\EstFormRowSize::LARGE}} />
<x-est-form-row ordinalNumber="5"  name='db' id="db" label="Data Management" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                value="{{$quotationData->db ?? ''}}" size="{{\App\Enums\EstFormRowSize::LARGE}}"/>
<x-est-form-row ordinalNumber="6" name='design' id="design" label="UI/UX Design Requirements" quotationDataId="{{$quotationData ? $quotationData->id : 0}}"
                value="{{$quotationData->design ?? ''}}" size="{{\App\Enums\EstFormRowSize::LARGE}}" />

