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
        "notificationType" =>"follow",
        "message" => "初めまして。〇〇株式会社の伊藤と申します先日は..."
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
        "notificationType" =>"follow",
        "message" => "先日お話した件について確認させていただきたいのですが、ご都合の良いにはありますでしょうか..."
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
        "notificationType" =>"like",
        "message" => "お世話になっております。〇〇株式会社の斎藤と申します。先日は...."
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
            <div class="pt-1 fs-2">メッセージ</div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="post-content">
                <!-- Dynamic content for Trend should be loaded here -->
                <ul id ="list-group" class="list-group list-unstyled">
                    <?php foreach ($posts as $post): ?>
                            <li class=" post border-top pt-2 pb-2">
                                <div class="d-flex">
                                    <span class="material-symbols-outlined fs-1">account_circle</span>
                                    <p class="mt-2"> <?= htmlspecialchars($post['user']) ?></p>
                                </div>
                                <div class="mx-5">
                                    <p> <?= htmlspecialchars($post['message']) ?> </p>
                                </div>
                                
                            </li>
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
<style>
        .post:hover {
            background-color: #f8f9fa; /* 薄いグレーの背景色 */
            cursor: pointer; /* オプショナル: ホバー時にカーソルをポインターに変更 */
        }
</style>