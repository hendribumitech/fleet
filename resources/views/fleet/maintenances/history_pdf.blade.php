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
                
        .table-header td {
            padding: 4px 2px;
        }

        .table-bordered{            
            border-collapse : collapse;	            
        }

        .table-bordered tr td{
            border: .5px solid #000;
            border-collapse : collapse;	
        }
        .table-bordered tr th {
            border: .5px solid #000;
            border-collapse : collapse;	            
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
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
        <br>
        <table class="table table-bordered text-center table-content">
            <thead>
                <tr>
                    <td>No. </td>
                    <td>Tanggal</td>
                    <td>Keterangan</td>
                    <td>Perbaikan / Sparepart</td>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    
                
                @foreach ($vehicle->maintenances as $maintenance)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $maintenance->start }} <br>
                            s.d <br> 
                            {{ $maintenance->end }}</td>
                        <td>{{ $maintenance->description }}</td>
                        <td class="text-left">
                            <div>Odometer : {{ $maintenance->odometer }}</div>
                            @if (!$maintenance->maintenanceServices->isEmpty())
                                <div>
                                    <h4>Pekerjaan : </h4>
                                    <ol>
                                        @foreach ($maintenance->maintenanceServices as $service)
                                        <li>{{ $service->description }}</li>    
                                        @endforeach                                        
                                    </ol>
                                </div>
                            @endif
                            @if (!$maintenance->maintenanceSpareparts->isEmpty())
                                <div>
                                    <h4>Sparepart : </h4>
                                    <ol>
                                        @foreach ($maintenance->maintenanceSpareparts as $sparepart)
                                        <li>{{ $sparepart->sparepart->name }} ({{ $sparepart->sparepart->code }}) - <strong>({{ $sparepart->quantity }})</strong></li>    
                                        @endforeach                                        
                                    </ol>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                @endfor
            </tbody>
        </table>
    </div>
</body>

</html>
