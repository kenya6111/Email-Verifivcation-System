
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
            <form action="send/message?user_id=<?= $groupedMessage['userID']?>"  method="post" enctype="multipart/form-data">
                <div class="border-top p-3 d-flex send-content" style="display:none!important;" id="send-<?= htmlspecialchars($groupedMessage['username']) ?>">
                    <input type="text" name="message" class="form-control mr-2" placeholder="新しいメッセージを作成">
                    <input type="hidden" name="csrf_token" value="<?= Helpers\CrossSiteForgeryProtection::getToken() ?>">
                    <button type="send" class="btn btn-primary">送信</button>
                </div>
            </form>
        <?php endforeach; ?>
    </div>
</div>

<script src="/js/message.js"></script>

