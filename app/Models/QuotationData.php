<?php

namespace App\Models;

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
       'description',
       'userflow',
       'requirements'
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
}
