<?php 

$posts=[
    [
        "id" => 1,
        "user"=> "tnk@engineer",
        "content"=> "人を笑わせることを志してきました。たくさんの人が自分の事で笑えなくなり、ただただ困惑し、悔しく悲しいです。。。。世間に真実が伝わり、一日も早く、お笑いがしたいです。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "notificationType" =>"follow"
    ],
    [
        "id" => 2,
        "user"=> "あさか🐰",
        "content"=> "配信遅れて申し訳ございません.今日は山根です。重ねて申し訳ございません",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "notificationType" =>"follow"
    ],
    [
        "id" => 3,
        "user"=> "ryotakasannnnnnn@SES営業",
        "content"=> "今日は素晴らしい一日でした！最近のプロジェクトが無事に完了し、チーム全体でお祝いです。次のチャレンジに向けて、これからも頑張ります。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "notificationType" =>"like"
    ],
    [
        "id" => 4,
        "user"=> "すぎっと/StudioDECER",
        "content"=> "基本情報技術者試験、見事合格〜！年末年始？そんなの関係ねぇ！！年末年始返上が実を結びました",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "notificationType" =>"message"
    ],
    [
        "id" => 5,
        "user"=> "utukawa@AI情報解説",
        "content"=> "人を笑わせることを志してきました。たくさんの人が自分の事で笑えなくなり、ただただ困惑し、悔しく悲しいです。。。。世間に真実が伝わり、一日も早く、お笑いがしたいです。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg",
        "notificationType" =>"reply"
    ],
]
?>
<div class="row d-flex w-100">
    <div class="col-2">
    </div>
    <div class="col-8  d-flex flex-column justify-content-center border ">
        <!-- トレンドorフォロワー-->
        <div class="btn-group border-bottom" role="group" aria-label="Basic example">
            <span class="material-symbols-outlined fs-2">arrow_back</span>
            <div class="pt-1 fs-2">通知</div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="post-content">
                <!-- Dynamic content for Trend should be loaded here -->
                <ul id ="list-group" class="list-group list-unstyled">
                    <?php foreach ($posts as $post): ?>
                        <?php if ($post['notificationType'] == 'follow'):?>
                            <li class=" post border-top pt-2 pb-2">
                                <div class="d-flex">
                                    <span class="material-symbols-outlined fs-1">person</span>
                                    <span class="material-symbols-outlined fs-1">account_circle</span>
                                </div>
                                <div class="mx-5">
                                    <p> <?= htmlspecialchars($post['user']) ?>さんにフォローされました。 </p>
                                </div>
                            </li>
                        <?php elseif($post['notificationType'] == 'like'): ?>
                            <li class=" post border-top pt-2 pb-2">
                                <div class="d-flex">
                                    <span class="material-symbols-outlined fs-1">favorite</span>
                                    <span class="material-symbols-outlined fs-1">account_circle</span>
                                </div>
                                <div class="mx-5">
                                    <p> <?= htmlspecialchars($post['user']) ?>さんがあなたの投稿にいいねしました。 </p>
                                </div>
                                <div class="mx-5 text-black-50">
                                    <p> <?= htmlspecialchars($post['content']) ?> </p>
                                </div>
                            </li>
                        <?php elseif($post['notificationType'] == 'message'): ?>
                            <li class=" post border-top pt-2 pb-2">
                                <div class="d-flex">
                                <span class="material-symbols-outlined fs-1">mail</span>
                                    <span class="material-symbols-outlined fs-1">account_circle</span>
                                </div>
                                <div class="mx-5">
                                    <p> <?= htmlspecialchars($post['user']) ?>さんからメッセージが届きました。 </p>
                                </div>
                            </li>
                        <?php else: ?>
                            <li class=" post border-top pt-2 pb-2">
                                <div class="d-flex">
                                    <span class="material-symbols-outlined fs-1">chat_bubble</span>
                                    <span class="material-symbols-outlined fs-1">account_circle</span>
                                </div>
                                <div class="mx-5">
                                    <p> <?= htmlspecialchars($post['user']) ?>さんがあなたの投稿に返信しました。 </p>
                                </div>
                            </li>
                        <?php endif; ?>

                    <?php endforeach; ?>
                </ul>
            </div>
            <!-- <div class="tab-pane fade show active" id="reply-content" style="display: none;">
                reply
            </div>
            <div class="tab-pane fade show active" id="media-content" style="display: none;">
                media
            </div>
            <div class="tab-pane fade show active" id="like-content" style="display: none;">
                like
            </div> -->
        </div>
    </div>
    <div class="col-2">
    </div>
</div>

<script src="/js/profile.js"></script>