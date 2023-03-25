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
        .table-bordered{            
            border-collapse : collapse;	            
        }

        .table-bordered tr td{
            border: .5px solid #000;
            border-collapse : collapse;	
            padding: 4px;
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

        tr { 
            page-break-inside: avoid; 
        }
    </style>

    <title>History Maintenance</title>
</head>

<body style="margin-bottom: 2pt">
    <div>        
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
            </tbody>
        </table>
    </div>
</body>

</html>
