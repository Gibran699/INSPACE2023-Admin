<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $ticket->slug }}</title>
</head>
<body>
    @if ($ticket->user_limit > 1)
    <table border="1">
        <tr>
            <td><b>Total</b></td>
            <td colspan="6">Rp. {{ number_format($ticket->total_income, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th><b>ID Ticket</b></th>
            <th><b>Payment Status</b></th>
            <th><b>CheckIn Status</b></th>
            <th><b>Nama Peserta</b></th>
            <th><b>No Hp</b></th>
            <th><b>Email</b></th>
            <th><b>Asal Institusi</b></th>
        </tr>
        @foreach ($ticket->participant_tickets as $key => $participant_ticket)
            <tr>
                <td rowspan="{{$ticket->user_limit}}">{{ $participant_ticket->id }}</td>
                <td rowspan="{{$ticket->user_limit}}" style="font-weight: {{ $participant_ticket->is_paid ? 'bold' : '100' }}">{{ $participant_ticket->is_paid ? "Sudah Bayar" : "Belum Bayar" }}</td>
                <td rowspan="{{$ticket->user_limit}}" style="font-weight: {{ $participant_ticket->is_checkin ? 'bold' : '100' }}">{{ $participant_ticket->is_checkin ? "Sudah CheckIn" : "Belum CheckIn" }}</td>
                <td>{{ $participant_ticket->participants[0]->nama }}</td>
                <td>{{ $participant_ticket->participants[0]->no_hp }}</td>
                <td>{{ $participant_ticket->participants[0]->email }}</td>
                <td>{{ $participant_ticket->participants[0]->institusi == 1 ? 'Kuliah' : ($participant_ticket->participants[0]->institusi == 2 ? 'SMA/SMK' : 'Umum') }}</td>
            </tr>
            @for ($i = 1; $i < $ticket->user_limit; $i++)
            <tr>
                <td>{{ $participant_ticket->participants[$i]->nama }}</td>
                <td>{{ $participant_ticket->participants[$i]->no_hp }}</td>
                <td>{{ $participant_ticket->participants[$i]->email }}</td>
                <td>{{ $participant_ticket->participants[$i]->institusi == 1 ? 'Kuliah' : ($participant_ticket->participants[$i]->institusi == 2 ? 'SMA/SMK' : 'Umum') }}</td>
            </tr>
            @endfor
        @endforeach
    </table>
    @else
    <table>
        <tr>
            <td><b>Total</b></td>
            <td colspan="6">Rp. {{ number_format($ticket->total_income, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <th><b>ID Ticket</b></th>
            <th><b>Payment Status</b></th>
            <th><b>CheckIn Status</b></th>
            <th><b>Nama Peserta</b></th>
            <th><b>No Hp</b></th>
            <th><b>Email</b></th>
            <th><b>Asal Institusi</b></th>
        </tr>
        @foreach ($ticket->participant_tickets as $participant_ticket)
            @foreach ($participant_ticket->participants as $participant)
                <tr>
                    <td>{{ $participant_ticket->id }}</td>
                    <td style="font-weight: {{ $participant_ticket->is_paid ? 'bold' : '100' }}">{{ $participant_ticket->is_paid ? "Sudah Bayar" : "Belum Bayar" }}</td>
                    <td rowspan="{{$ticket->user_limit}}" style="font-weight: {{ $participant_ticket->is_checkin ? 'bold' : '100' }}">{{ $participant_ticket->is_checkin ? "Sudah CheckIn" : "Belum CheckIn" }}</td>
                    <td>{{ $participant->nama }}</td>
                    <td>{{ $participant->no_hp }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->institusi == 1 ? 'Kuliah' : ($participant->institusi == 2 ? 'SMA/SMK' : 'Umum') }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>
    @endif
</body>
</html>
