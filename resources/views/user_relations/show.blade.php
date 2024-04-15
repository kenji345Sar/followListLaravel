<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User 10 Relations</title>

<style>
  .pagination svg {
    width: 1rem;  /* 16pxに相当 */
    height: 1rem; /* 16pxに相当 */
  }
</style>

</head>
<body>
    <h1>User Relations for User 10</h1>
    <form action="{{ url('/user-10-relations') }}" method="GET">
        <select name="type">
            <option value="all"{{ $type == 'all' ? ' selected' : '' }}>All</option>
            <option value="following"{{ $type == 'following' ? ' selected' : '' }}>Following</option>
            <option value="followers"{{ $type == 'followers' ? ' selected' : '' }}>Followers</option>
            <option value="blocking"{{ $type == 'blocking' ? ' selected' : '' }}>Blocking</option>
            <option value="blockedBy"{{ $type == 'blockedBy' ? ' selected' : '' }}>Blocked By</option>
        </select>
        <button type="submit">Filter</button>
    </form>
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
                @php
                    $isFollowing = in_array($id, $userRelations['following']);
                    $isFollower = in_array($id, $userRelations['followers']);
                    $isMutual = in_array($id, $userRelations['mutual']);
                    $isBlocking = in_array($id, $userRelations['blocking']);
                    $isBlockedBy = in_array($id, $userRelations['blockedBy']);
                    // フィルターに関連するIDのみ行を表示するか判断
                    $displayRow = $type === 'all' || $isFollowing || $isFollower || $isBlocking || $isBlockedBy;
                @endphp
                @if ($displayRow)
                    <tr>
                        <td>{{ $id }}</td>
                        <td>{{ $isFollowing ? '○' : '' }}</td>
                        <td>{{ $isFollower ? '○' : '' }}</td>
                        <td>{{ $isMutual && ($type === 'all' || $type === 'following' || $type === 'followers') ? '○' : '' }}</td>
                        <td>{{ $isBlocking ? '○' : '' }}</td>
                        <td>{{ $isBlockedBy ? '○' : '' }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>
</html>
