<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $program->slug }}</title>
</head>
<body>
    @if ($program->is_group == 1)
    <table border="1">
        <tr>
            <td><b>Asal Instansi</b></td>
            <td><b>Nama Tim</b></td>
            <td><b>Nama Anggota TIM</b></td>
            <td><b>NIM/NIS</b></td>
            <td><b>Status Pembayaran</b></td>
            @foreach ($program->stagesData->get('stage_list') as $stage)
                <td><b>{{ $stage->label }}</b></td>
            @endforeach
        </tr>
        @foreach ($program->program_teams as $program_team)
        <tr>
            <td rowspan="{{$program->max_team}}">{{ $program_team->team->institution }}</td>
            <td rowspan="{{$program->max_team}}">{{ $program_team->team->name }}</td>
            <td>{{ $program_team->team->user->name }}</td>
            <td>{{ strval($program_team->team->user->number_id) }}</td>
            <td rowspan="{{$program->max_team}}" style="font-weight: {{ $program_team->is_paid ? 'bold' : '100' }}">{{ $program_team->is_paid ? 'Sudah Bayar' : 'Belum Bayar' }}</td>
            @foreach ($program_team->stagesDoc->d() as $key => $doc)
            <td rowspan="{{$program->max_team}}" style="font-weight: {{!$program_team->stagesDoc->d()[$key]->status && $program_team->stagesDoc->d()[$key]->file !== null ? 'bold' : '100'}}">
                @if (!$program_team->stagesDoc->d()[$key]->status && date('Y-m-d H:i:s', strtotime($program->stagesData->get('stage_list')[$key]->end_selection)) < now())
                    <span><b>Tereliminasi</b></span>
                @elseif (!$program_team->stagesDoc->d()[$key]->status)
                    <span>{{$program_team->stagesDoc->d()[$key]->file !== null ? 'Telah Upload Berkas' : 'Belum Upload Berkas' }}</span>
                @else
                    <span><b>Lolos</b></span>
                @endif
            </td>
            @endforeach
        </tr>
        @for ($i = 0; $i < $program->max_team - 1; $i++)
        <tr>
            @if ($program_team->team->team_users->has($i))
            <td>{{ $program_team->team->team_users[$i]->user->name }}</td>
            <td>{{ strval($program_team->team->team_users[$i]->user->number_id) }}</td>
            @else
            <td></td>
            <td></td>
            @endif
        </tr>
        @endfor
        @endforeach
    </table>
    @else
    <table>
        <tr>
            <td><b>Asal Instansi</b></td>
            <td><b>Nama Peserta</b></td>
            <td><b>NIM/NIS</b></td>
            <td><b>Status Pembayaran</b></td>
            @foreach ($program->stagesData->get('stage_list') as $stage)
                <td><b>{{ $stage->label }}</b></td>
            @endforeach
        </tr>
        @foreach ($program->program_teams as $program_team)
        <tr>
            <td>{{ $program_team->user->institution }}</td>
            <td>{{ $program_team->user->name }}</td>
            <td>{{ $program_team->user->number_id }}</td>
            <td style="font-weight: {{ $program_team->is_paid ? 'bold' : '100' }}">{{ $program_team->is_paid ? 'Sudah Bayar' : 'Belum Bayar' }}</td>
            @foreach ($program_team->stagesDoc->d() as $key => $doc)
            <td style="font-weight: {{!$program_team->stagesDoc->d()[$key]->status && $program_team->stagesDoc->d()[$key]->file !== null ? 'bold' : '100'}}">
                @if (!$program_team->stagesDoc->d()[$key]->status && date('Y-m-d H:i:s', strtotime($program->stagesData->get('stage_list')[$key]->end_selection)) < now())
                    <span><b>Tereliminasi</b></span>
                @elseif (!$program_team->stagesDoc->d()[$key]->status)
                    <span>{{$program_team->stagesDoc->d()[$key]->file !== null ? 'Telah Upload Berkas' : 'Belum Upload Berkas' }}</span>
                @else
                    <span><b>Lolos</b></span>
                @endif
            </td>
            @endforeach
        </tr>
        @endforeach
    </table>
    @endif
</body>
</html>
