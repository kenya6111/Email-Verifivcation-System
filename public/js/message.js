document.addEventListener("DOMContentLoaded", function() {
    var messageListItems = document.querySelectorAll('#messageList .list-group-item');
    
    messageListItems.forEach(function(item) {
        item.addEventListener('click', function() {
            // すべてのメッセージコンテンツを非表示にする
            document.querySelectorAll('.message-content').forEach(function(content) {
                content.style.display = 'none';
            });

            // すべての送信エリアコンテンツを非表示にする
            document.querySelectorAll('.send-content').forEach(function(content) {
                content.style.setProperty('display', 'none', 'important');
                // content.style.display = 'none';
                // console.log("Hiding element: ", content); // デバッグ用ログ
            });

            

            // クリックされたメッセージに対応するコンテンツを表示する
            var index = item.id.split('-')[1];
            var contentId = 'content-' + index;
            var sendBoxId = 'send-' + index;
            document.getElementById(contentId).style.display = 'block';
            document.getElementById(sendBoxId).style.display = 'block';

            // デフォルトメッセージを非表示にする
            document.getElementById('default-message').style.display = 'none';
        });
    });
});