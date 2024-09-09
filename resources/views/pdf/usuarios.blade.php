<!DOCTYPE html>
<html>
<head>
    <title>Usu�rios</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Usuários</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Telefone</th>
                <th>CEP</th>
                <th>Email</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->id }}</td>
                    <td>{{ $usuario->nome }}</td>
                    <td>{{ $usuario->cpf }}</td>
                    <td>{{ $usuario->dataNascimento }}</td>
                    <td>{{ $usuario->telefone }}</td>
                    <td>{{ $usuario->cep }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->status == 1 ? 'ativo' : 'inativo' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
