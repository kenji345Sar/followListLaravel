<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRelation;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRelationController extends Controller
{
    public function index()
    {
        $userRelations = UserRelation::all();  // すべてのユーザー関係データを取得
        return view('user_relations.index', compact('userRelations'));
    }

    public function showUser10Relations(Request $request)
    {
        DB::enableQueryLog();

        $type = $request->input('type', 'all'); // Default to 'all' to show all relations

        // Get all relations for user 10
        $relationsQuery = $this->getUserRelationsQuery();

        // フィルタリング用に関連ユーザーIDを取得
        $relatedUserIdsQuery = UserRelation::select('user_id', 'target_user_id')
                                    ->where(function ($query) {
                                        $query->where('user_id', 10)
                                            ->orWhere('target_user_id', 10);
                                    })
                                    ->get();

    // user_id または target_user_id が 10 である関連ユーザーの user_id と target_user_id を抽出
    $allUserIds = $relatedUserIdsQuery->pluck('user_id')
                                    ->merge($relatedUserIdsQuery->pluck('target_user_id'))
                                    ->unique()
                                    ->reject(function ($id) {
                                        return $id == 10;
                                    })
                                    ->sort()
                                    ->values()
                                    ->all();

    // $filteredUserIds = array_filter($allUserIds, function($id) {
    //     return $id != 10;  // ID 10 を除外
    // });


// dd($allUserIds);
        // タイプに基づいて関係データをフィルタリング
        $userRelations = $this->filterRelations($relationsQuery, $type);
// dd($userRelations);


    // // ページネーション
    // $perPage = 5; // 1ページあたりのアイテム数
    // $page = $request->input('page', 1); // 現在のページ（デフォルトは1）
    // $total = count($allUserIds); // 総アイテム数

    // $result = new LengthAwarePaginator(
    //     array_slice($allUserIds, ($page - 1) * $perPage, $perPage), // アイテムのスライス
    //     $total, // 総アイテム数
    //     $perPage, // 1ページあたりのアイテム数
    //     $page, // 現在のページ
    //     ['path' => $request->url(), 'query' => $request->query()] // ページネーションのURL
    // );

    // // ビューにデータを渡す
    // return view('user_relations.show', [
    //     'type' => $type,
    //     'userRelations' => $userRelations,
    //     'userIds' => $result, // ページネーションされたアイテム
    // ]);

        // ビューにフィルタリングされたデータを渡す
        return view('user_relations.show', [
            'type' => $type,
            'userRelations' => $userRelations,
            'userIds' => $allUserIds, // 関連するすべてのユーザーIDをビューに渡す
        ]);

    }

    private function getUserRelationsQuery()
    {
        // DB::enableQueryLog();
        // Query to fetch all user relations involving user 10
        return UserRelation::select(
            'user_id',
            'target_user_id',
            DB::raw('CASE WHEN user_id = 10 AND is_blocking = 0 THEN 1 ELSE 0 END as following'),
            DB::raw('CASE WHEN target_user_id = 10 AND is_blocking = 0 THEN 1 ELSE 0 END as followed_by'),
            DB::raw("CASE WHEN user_id = 10 AND is_blocking = 0 AND EXISTS (
                SELECT 1 FROM user_relations ur2
                WHERE ur2.user_id = target_user_id AND ur2.target_user_id = user_id AND ur2.is_blocking = 0
            ) THEN 1 ELSE 0 END as both_follow"),
            DB::raw('CASE WHEN user_id = 10 AND is_blocking = 1 THEN 1 ELSE 0 END as blocking'),
            DB::raw('CASE WHEN target_user_id = 10 AND is_blocking = 1 THEN 1 ELSE 0 END as blocked_by')
        )->where(function ($query) {
            $query->where('user_id', 10)->orWhere('target_user_id', 10);
        })->get();

        // dd(DB::getQueryLog());
    }

    private function getRelatedUserIds($relationsQuery)
    {
        // Collect all unique user IDs from the relationships
        return $relationsQuery->pluck('user_id')
            ->merge($relationsQuery->pluck('target_user_id'))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function filterRelations($relations, $type)
    {
        $filtered = [
            'following' => [],
            'followers' => [],
            'blocking' => [],
            'blockedBy' => [],
            'mutual' => []
        ];

        foreach ($relations as $relation) {
            if ($relation->following && $relation->user_id == 10) {
                $filtered['following'][] = $relation->target_user_id;
            }
            if ($relation->followed_by && $relation->target_user_id == 10) {
                $filtered['followers'][] = $relation->user_id;
            }
            if ($relation->blocking && $relation->user_id == 10) {
                $filtered['blocking'][] = $relation->target_user_id;
            }
            if ($relation->blocked_by && $relation->target_user_id == 10) {
                $filtered['blockedBy'][] = $relation->user_id;
            }
        }

        // Calculate mutual following
        $filtered['mutual'] = array_intersect($filtered['following'], $filtered['followers']);

        // Rebuild the array based on the filter type if it's not 'all'
        if ($type !== 'all') {
            foreach (['following', 'followers', 'blocking', 'blockedBy'] as $relationType) {
                if ($type !== $relationType) {
                    $filtered[$relationType] = [];
                }
            }
        }

        return $filtered;
    }

    
    
}
