<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>all-participant</title>
</head>
<body>
    <table border="1">
        <tr>
            <th><b>Nama Peserta</b></th>
            <th><b>No Hp</b></th>
            <th><b>Email</b></th>
            <th><b>Asal Institusi</b></th>
            <th><b>Ticket</b></th>
            <th><b>Status Kehadiran</b></th>
        </tr>
        @foreach ($participants as $key => $participant)
            <tr>
                <td>{{ $participant->nama }}</td>
                <td>{{ $participant->no_hp }}</td>
                <td>{{ $participant->email }}</td>
                <td>{{ $participant->institusi == 1 ? 'Kuliah' : ($participant->institusi == 2 ? 'SMA/SMK' : 'Umum') }}</td>
                <td>{{ $participant->participantTicket->ticket->name }}</td>
                <td>{{ $participant->is_checkin == 1 ? 'Hadir' : 'Tidak Hadir' }}</td>
            </tr>
        @endforeach
    </table>
</body>
</html>
