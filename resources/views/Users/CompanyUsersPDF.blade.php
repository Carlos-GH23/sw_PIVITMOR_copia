<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Empresas</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header {
            position: relative;
            margin-bottom: 24px;
            width: 100%;
            height: 80px;
        }
        .header-title {
            position: absolute;
            left: 0;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2.6em;
            font-weight: bold;
            letter-spacing: 2px;
            color: #283C2A;
            margin: 0;
            text-align: center;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #E6F4EA; }
        th { background: #E6F4EA; color: #283C2A; border: 1px solid #283C2A; padding: 6px; text-align: left; }
        td { background: #fff; border: 1px solid #283C2A; padding: 6px; text-align: left; }
        h2 { color: #283C2A; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <span class="header-title">CCYTEM</span>
    </div>
    <h2>Listado de Empresas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Razón Social</th>
                <th>RFC</th>
                <th>Año</th>
                <th>Estado</th>
                <th>Misión</th>
                <th>Visión</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{ $company->id }}</td>
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->legal_name }}</td>
                    <td>{{ $company->rfc }}</td>
                    <td>{{ $company->year }}</td>
                    <td>{{ $company->is_active ? 'Activa' : 'Inactiva' }}</td>
                    <td>{{ strip_tags($company->mission) }}</td>
                    <td>{{ strip_tags($company->vision) }}</td>
                    <td>{{ strip_tags($company->overview) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
