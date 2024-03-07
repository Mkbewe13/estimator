<?php

namespace App\Models;

use App\Enums\QuotationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class QuotationData extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
       'name',
       'objectives',
       'features',
       'roles',
        'integrations',
        'db',
        'design',
        'deploy',
        'scalability',
        'maintenance',
        'tech',
        'status'
    ];

    public function frontQuotationResult()
    {
        $result = DB::table('quotation_results')
            ->where('quotation_data_id',$this->id)
            ->where('project_side','frontend')
        ->first();
        return $result;
    }

    public function backQuotationResult()
    {
        $result = DB::table('quotation_results')
            ->where('quotation_data_id',$this->id)
            ->where('project_side','backend')
            ->first();
        return $result;
    }

    public function getProjectData(){
        return [
            'Project Goals and Objectives' => $this->objectives,
            'Feature List' => $this->features,
            'User Roles and Permissions' => $this->roles,
            'Integration Points' => $this->integrations,
            'Data Management' => $this->db,
            'UI/UX Design Requirements' => $this->design,
            'Deployment Environment' => $this->deploy,
            'Scalability and Performance Requirements' => $this->scalability,
            'Maintenance and Update Plans' => $this->maintenance,
            'Tools and Technologies Preferences' => $this->tech,
        ];
    }

}
