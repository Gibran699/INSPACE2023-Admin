<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Comittee;
use App\Models\ProgramTeam;
use App\Models\User;
use App\Models\Team;
use App\Helpers\AdditionalDataHelper;

class Program extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'stage' => 'array',
        'timeline' => 'array'
    ];

    public function comittee(){
        return $this->belongsTo(Comittee::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function team(){
        return $this->belongsTo(Team::class);
    }

    public function program_themes(){
        return $this->hasMany(ProgramTheme::class);
    }

    public function program_teams()
    {
        return $this->hasMany(ProgramTeam::class);
    }

    public function getStagesDataAttribute()
    {
        return new AdditionalDataHelper($this->stage);
    }

    public function getCurrentStageAttribute()
    {
        $data = collect($this->stagesData->get('stage_list'))->filter(function ($item, $key){
            if (date('Y-m-d H:i:s', strtotime($item->open_registration)) <= now() && date('Y-m-d H:i:s', strtotime($item->announcement)) >= now()) {
                return $item;
            }
        })->toArray();

        if (empty($data)) {
            return array_key_last($this->stagesData->d()->stage_list);
        }

        return array_key_first($data);
    }

    public function getCurrentStageDataAttribute()
    {
        return $this->stagesData->stage_list[$this->currentStage];
    }

    public function getIsAfterStageAttribute()
    {
        return date('Y-m-d H:i:s', strtotime($this->stagesData->d()->stage_list[array_key_last($this->stagesData->d()->stage_list)]->announcement)) < now();
    }

    public function getLastStageAttribute()
    {
        return $this->stagesData->d()->stage_list[array_key_last($this->stagesData->d()->stage_list)];
    }
}
