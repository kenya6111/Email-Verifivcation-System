<?php

$dummyposts=[
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
        "image"=> "https://example.com/path/to/image.jpg"
    ],
    [
        "id" => 2,
        "user"=> "有吉弘行",
        "content"=> "配信遅れて申し訳ございません.今日は山根です。重ねて申し訳ございません",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg"
    ],
    [
        "id" => 3,
        "user"=> "ゆっちゃん@java勉強中",
        "content"=> "今日は素晴らしい一日でした！最近のプロジェクトが無事に完了し、チーム全体でお祝いです。次のチャレンジに向けて、これからも頑張ります。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg"
    ],
    [
        "id" => 4,
        "user"=> "ryooootasaaaaam",
        "content"=> "基本情報技術者試験、見事合格〜！年末年始？そんなの関係ねぇ！！年末年始返上が実を結びました",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg"
    ],
    [
        "id" => 5,
        "user"=> "あさか🐰",
        "content"=> "人を笑わせることを志してきました。たくさんの人が自分の事で笑えなくなり、ただただ困惑し、悔しく悲しいです。。。。世間に真実が伝わり、一日も早く、お笑いがしたいです。",
        "likes"=> 23,
        "comments"=> [
            [
                "user"=> "mng_nq",
                "comment"=> "おめでとう！次も頑張って！"
            ]
        ],
        "image"=> "https://example.com/path/to/image.jpg"
    ],
]

?>
<div class="row d-flex w-100">
    <div class="col-2">
        <div>
            <a href="/profile?user_id=<?= htmlspecialchars($loginUserId);?>">
                <span class="material-symbols-outlined ms-2 fs-1">account_circle</span>
            </a>
            <h5 class="ms-3 pt-2"><?=htmlspecialchars($post['username']) ?></h5>    
        </div>
    </div>
    <div class="col-8  d-flex flex-column justify-content-center border ">
        <!-- トレンドorフォロワー-->
        <div class="btn-group border-bottom" role="group" aria-label="Basic example">
            <button type="button" class="btn me-5" id="trend-btn">Trend</button>
            <button type="button" class="btn ms-5" id="follow-btn">Follower</button>
        </div>
        <!-- ポストフィールド -->
        <div class="card">
            <div class="card-body">
                <form action="form/post" id="send-form" method="post" enctype="multipart/form-data">
                    <input id="csrf_token" type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
                    <div class="mb-3">
                        <textarea class="form-control" name="text" placeholder="write something here " rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file-upload" class="form-label"><i class="fas fa-camera"></i> メディアをアップロード</label>
                        <input type="file" class="form-control" id="file-upload" name="file-upload">
                    </div>
                    <button type="submit" class="btn btn-primary float-end">ポストする</button>
                </form>
            </div>
        </div>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="trend-content">
                <!-- Dynamic content for Trend should be loaded here -->
                <ul id ="list-group" class="list-group list-unstyled">
                    <?php foreach ($posts as $post): ?>
                        <input id="post_id" type="hidden" name="post_id" value="<?= $post['post_id']?>">
                        <input id="user_id" type="hidden" name="user_id" value="<?= $post['user_id']?>">
                        <?php $modalId = 'exampleModal' . $post['id']; ?>
                        <li class=" post border-top pt-2 pb-2 clickable-post" data-url="/post?post_id=<?= $post['post_id'];?>">
                                <div class="d-flex">
                                    <a href="/profile?user_id=<?= $post['id'];?>">
                                        <span class="material-symbols-outlined ms-2 fs-1">account_circle</span>
                                    </a>
                                    <h5 class="ms-3 pt-2"><?=htmlspecialchars($post['username']) ?></h5>
                                </div>
                                <div class="mx-5">
                                    <p> <?= htmlspecialchars($post['message']) ?> </p>
                                </div>
                                <div class="mx-5 mb-3">
                                    <img src=" <?= "/uploads/".$post['image'] ?>" class="img-fluid" alt="">
                                </div>
                                <div>
                                    <div class="row justify-content-end">
                                        <div class="col-3">
                                            <div id="like-button-after" class="d-none">💗</div>
                                            <span id="like-button-before" class="material-symbols-outlined">favorite</span><?= $post['like_count']?>
                                        </div>
                                        <div class="col-3 reply-btn" >
                                            <!-- <span class="material-symbols-outlined">chat_bubble</span> -->
                                            <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#<?= $modalId ?>">
                                              返信
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- モーダルの本体 -->
                                <div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">ポップアップ</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="card">
                                        <div class="card-body">
                                            <form action="form/post?post_id=<?= $post['post_id']?>&user_id=<?= $post['user_id']?>" id="send-form" method="post" enctype="multipart/form-data">
                                                <input id="csrf_token_popup" type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
                                                <div class="mb-3">
                                                    <textarea class="form-control" name="text" placeholder="write something here " rows="3"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="file-upload" class="form-label"><i class="fas fa-camera"></i> メディアをアップロード</label>
                                                    <input type="file" class="form-control" id="file-upload" name="file-upload">
                                                </div>
                                                <button type="submit" class="btn btn-primary float-end post-btn-popup">ポストする</button>
                                            </form>
                                        </div>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary close-btn-popup" data-bs-dismiss="modal">閉じる</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
            
            <div class="tab-pane fade show active" id="follower-content" style="display: none;">
                <!-- Dynamic content for Followers should be loaded here -->
                follower
            </div>
        </div>
    </div>
    <div class="col-2">
    </div>
</div>

<script src="/js/home.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
