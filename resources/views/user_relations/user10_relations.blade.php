{{-- resources/views/user_relations/index.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Relations</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Follow</th>
                <th>Follower</th>
                <th>Mutual</th>
                <th>Blocking</th>
                <th>Blocked By</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userIds as $id)
            <tr>
                <td>{{ $id }}</td>
                <td>{{ in_array($id, $following) ? '○' : '' }}</td>
                <td>{{ in_array($id, $followers) ? '○' : '' }}</td>
                <td>{{ in_array($id, $mutual) ? '○' : '' }}</td>
                <td>{{ in_array($id, $blocking) ? '○' : '' }}</td>
                <td>{{ in_array($id, $blockedBy) ? '○' : '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
