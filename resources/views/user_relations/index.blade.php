<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Relations</title>
</head>
<body>
    <h1>User Relations</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Relation ID</th>
                <th>User ID</th>
                <th>Target User ID</th>
                <th>Is Blocking</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userRelations as $relation)
                <tr>
                    <td>{{ $relation->relation_id }}</td>
                    <td>{{ $relation->user_id }}</td>
                    <td>{{ $relation->target_user_id }}</td>
                    <td>{{ $relation->is_blocking ? 'Yes' : 'No' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
