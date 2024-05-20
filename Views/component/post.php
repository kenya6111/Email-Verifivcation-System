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
        "image"=> "https://example.com/path/to/image.jpg"
    ]
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
            <a href="/homepage">
                <span class="material-symbols-outlined fs-2">arrow_back</span>
            </a>
            <div class="pt-1">Posting</div>
        </div>
        <!-- ポストフィールド -->
        <!-- <div class="card">
            <div class="card-body">
                <form action="form/post" id="send-form" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
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
        </div> -->

        <div class="tab-content">
            <div class="tab-pane fade show active" id="trend-content">
                <ul id ="list-group" class="list-group list-unstyled">
                        <li class=" post border-top pt-2 pb-2">
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
                                        <span class="material-symbols-outlined">favorite</span>
                                    </div>
                                    <div class="col-3">
                                        <span class="material-symbols-outlined">chat_bubble</span>
                                    </div>
                                </div>
                            </div>
                            <div class="mx-5 mb-3">
                                <?= $post['created_at'] ?>
                            </div>
                            <div>
                                <form action="form/post" id="send-form" method="post" enctype="multipart/form-data">
                                    <input id="csrf_token" type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
                                    <div class="mb-3">
                                        <textarea class="form-control" name="text" placeholder="write something here " rows="3"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="file-upload" class="form-label"><i class="fas fa-camera"></i> メディアをアップロード</label>
                                        <input type="file" class="form-control" id="file-upload" name="file-upload">
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">返信</button>
                                </form>
                            </div>
                        </li>
                        
                        <?php function renderPosts($replys) { ?>
                            <?php foreach ($replys as $reply): ?>
                                <li class="post border-top pt-2 pb-2">
                                    <div class="d-flex">
                                        <a href="/profile?user_id=<?= $reply['id']; ?>">
                                            <span class="material-symbols-outlined ms-2 fs-1">account_circle</span>
                                        </a>
                                        <h5 class="ms-3 pt-2"><?= htmlspecialchars($reply['user']) ?></h5>
                                    </div>
                                    <div class="mx-5">
                                        <p><?= htmlspecialchars($reply['message']) ?></p>
                                    </div>
                                    <?php if (!empty($reply['image'])): ?>
                                        <div class="mx-5 mb-3">
                                            <img src=" <?= "/uploads/".$reply['image'] ?>" class="img-fluid" alt="">
                                        </div>
                                    <?php endif; ?>
                                    <div class="row justify-content-end">
                                        <div class="col-3">
                                            <span class="material-symbols-outlined">favorite</span> <?= $reply['likes'] ?>
                                        </div>
                                        <div class="col-3">
                                            <button type="button" class="btn btn-primary btn-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#replyModal<?= $reply['id'] ?>">
                                                返信
                                            </button>
                                        </div>
                                    </div>
                                    <div class="mx-5 mb-3">
                                        <?= $reply['created_at'] ?>
                                    </div>
                                    
                                    <!-- モーダルの本体 -->
                                    <div class="modal fade" id="replyModal<?= $reply['id'] ?>" tabindex="-1" aria-labelledby="replyModalLabel<?= $reply['id'] ?>" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="replyModalLabel<?= $reply['id'] ?>">返信ポップアップ</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="form/post?reply_to_id=<?= $reply['id'] ?>" method="post" enctype="multipart/form-data">
                                                        <input id="csrf_token_popup" type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
                                                        <div class="mb-3">
                                                            <textarea class="form-control" name="text" placeholder="write something here" rows="3"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="file-upload" class="form-label"><i class="fas fa-camera"></i> メディアをアップロード</label>
                                                            <input type="file" class="form-control" id="file-upload" name="file-upload">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary float-end">ポストする</button>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 子ポストを表示 -->
                                    <?php if (!empty($reply['children'])): ?>
                                        <ul class="list-group list-unstyled ms-3">
                                            <?= renderPosts($reply['children']) ?>
                                        </ul>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php } ?>

                        <?php renderPosts($replys); ?>
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

<!-- <script src="/js/home.js"></script> -->