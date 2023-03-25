<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css" media="all">
        .table {
            font-size: 85%;
            vertical-align: top;
            width: 100%;            
        }                
    </style>

    <title>History Maintenance</title>
</head>

<body style="margin-bottom: 2pt">
    <div>
        <table class="table-header">
            <tr>
                <td>                    
                    <img width="118" height="46" src="{{ $base64 }}" />
                </td>
                <td>
                    <div style="font-size:120%">HISTORY MAINTENANCE</div>
                    <div style="font-size:120%">{{ $vehicle->name }}</div>
                </td>

            </tr>
        </table>
        <hr>
        <table class="table table-header">
            <tbody>
                <tr>
                    <td>Nopol</td>
                    <td> : {{ $vehicle->registration_number }}</td>
                    <td style="width:10%">&nbsp;</td>
                    <td>Merk</td>
                    <td> : {{ $vehicle->merk }}</td>
                </tr>
                <tr>
                    <td>Kapasitas Silinder</td>
                    <td> : {{ $vehicle->cilinder_capacity }}</td>
                    <td style="width:30%">&nbsp;</td>
                    <td>Tahun</td>
                    <td> : {{ $vehicle->registration_year }}</td>
                </tr>
            </tbody>
        </table>        
    </div>
</body>

</html>
