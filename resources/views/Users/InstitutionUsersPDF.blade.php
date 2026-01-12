<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Instituciones</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header {
            position: relative;
            margin-bottom: 24px;
            width: 100%;
            height: 80px;
        }
        .header img {
            position: absolute;
            left: 0;
            top: 0;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
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
        .header-title {
            font-size: 2.6em;
            font-weight: bold;
            letter-spacing: 2px;
            color: #283C2A;
            margin: 0;
        }
        .header img {
            height: 56px;
            margin-right: 18px;
            border-radius: 50%;
        }
        .header-title {
            font-size: 2.6em;
            font-weight: bold;
            letter-spacing: 2px;
            color: #283C2A;
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
    <h2>Listado de Usuarios con rol de Institución</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($institutions as $institution)
                <tr>
                    <td>{{ $institution->id }}</td>
                    <td>{{ $institution->name }}</td>
                    <td>{{ $institution->institutionType->name ?? '-' }}</td>
                    <td>{{ $institution->institutionType->institutionCategory->name ?? '-' }}</td>
                    <td>{{ strip_tags($institution->description) }}</td>
                    <td>
                        @if ($institution->is_active)
                            <span style="color: #283C2A; font-weight: bold;">Activa</span>
                        @else
                            <span style="color: #888; font-weight: bold;">Inactiva</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
