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
<div class="row d-flex w-100 vh-100">
    <div class="col-2">
    </div>
    <div class="col-4  d-flex flex-column justify-content-start border ">
        <!-- トレンドorフォロワー-->
        <div class="btn-group border-bottom " role="group" aria-label="Basic example">
            <a href="/homepage">
                <span class="material-symbols-outlined fs-2">arrow_back</span>
            </a>
            <div class="pt-1 fs-2">メッセージ</div>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="post-content">
                <!-- Dynamic content for Trend should be loaded here -->
                <ul id ="messageList" class="list-group list-unstyled">
                    <?php foreach ($groupedMessages as $groupedMessage): ?>
                            <li class="list-group-item post border-top pt-2 pb-2" id="message-<?= htmlspecialchars($groupedMessage['username']) ?>">
                                <div class="d-flex">
                                    <span class="material-symbols-outlined fs-1">account_circle</span>
                                    <p class="mt-2"> <?= htmlspecialchars($groupedMessage['username']) ?></p>
                                </div>
                            </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-6 message-area d-flex flex-column vh-100">
        <div id="default-message" class="d-flex flex-grow-1 justify-content-center align-items-center" >
            <div class="text-center" style="display:none;">
               <h1>メッセージを選択</h1>
                <p>既存の会話から選択したり、新しい会話を開始したりできます。</h3>
            </div>
        </div>
        <?php foreach ($groupedMessages as $groupedMessage): ?>
            <!-- メッセージヘッダー -->

            <div id="content-<?= htmlspecialchars($groupedMessage['username']) ?>" class="message-content" style="display:none;">
                <?php foreach ($groupedMessage['messages'] as $message): ?>
                    <div  class="flex-grow-1 overflow-auto p-3">
                        <?php if ($message['send_user_id'] != $loginUserId):?>
                            <div class="d-flex mb-3">
                                <div class="bg-light rounded p-2">
                                    <p class="mb-0"><?= htmlspecialchars($message['message']) ?></p>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="d-flex justify-content-end mb-3">
                                <div class="bg-primary text-white rounded p-2">
                                    <p class="mb-0"><?= htmlspecialchars($message['message']) ?></p>
                                </div>
                                <span class="material-symbols-outlined fs-1">account_circle</span>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
        <div class="border-top p-3 d-flex">
            <input type="text" class="form-control mr-2" placeholder="新しいメッセージを作成">
            <button class="btn btn-primary">送信</button>
        </div>
    </div>
</div>

<script src="/js/message.js"></script>

<!-- message画面を表示
→各ユーザとのメッセージボックスリストの表示（各相手とのメッセージもすべて右側のエリアにレンダリングして、各メッセージボックスを押すとdisplayがblock担って表示される感じにするか）
→各ボックスを押すとメッセージする画面を表示
→各ボックスを押すたびにそのユーザとのメッセージログを表示する -->

<!-- 各リストボックスでは「ユーザの名前」と「新着のメッセージ」を部分的に表示する -->
<!-- 
<style>
.message-area{
    height:100%;
}
</style> -->
