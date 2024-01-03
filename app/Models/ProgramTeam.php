<?php

namespace App\Models;

use App\Helpers\AdditionalDataHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\Program;
use App\Models\ProgramTheme;
use App\Models\Team;
use App\Models\User;

class ProgramTeam extends Model
{
    use  Notifiable;

    protected $table = 'program_team';

    protected $fillable = [
        'program_id',
        'team_id',
        'user_id',
        'program_theme_id',
        'file_stage_1',
        'file_stage_2',
        'file_stage_3',
        'proposal',
        'originality',
        'result_link',
        'presentation',
        'twibbon',
        'payment_proof',
        'is_paid',
        'stage_doc'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function program_theme()
    {
        return $this->belongsTo(ProgramTheme::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStagesDocAttribute()
    {
        return new AdditionalDataHelper($this->stage_doc);
    }

    public function getIsCurrentStageNotSubmitedAttribute()
    {
        return !$this->stagesDoc->d()[$this->program->current_stage]->status && date('Y-m-d H:i:s', strtotime($this->program->stagesData->get('stage_list')[$this->program->current_stage]->end_selection)) < now();
    }

    public function getLastFinishedStageAttribute(){
        $data = array_key_first(collect($this->stagesDoc->d())->where('status',0)->toArray());
        if (!$data) {
            $data = array_key_last(collect($this->stagesDoc->d())->where('status',1)->toArray());
        }

        return $data;
    }
}
