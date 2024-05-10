
const postContent = document.getElementById('post-content');
const replyContent = document.getElementById('reply-content');
const mediaContent = document.getElementById('media-content');
const likeContent = document.getElementById('like-content');

function postTabClick(){
    postContent.style.display = 'block';
    replyContent.style.display = 'none';
    mediaContent.style.display = 'none';
    likeContent.style.display = 'none';
}
function replyTabClick(){
    postContent.style.display = 'none';
    replyContent.style.display = 'block';
    mediaContent.style.display = 'none';
    likeContent.style.display = 'none';
}
function mediaTabTabick(){
    postContent.style.display = 'none';
    replyContent.style.display = 'none';
    mediaContent.style.display = 'block';
    likeContent.style.display = 'none';
}
function likeTabClick(){
    postContent.style.display = 'none';
    replyContent.style.display = 'none';
    mediaContent.style.display = 'none';
    likeContent.style.display = 'block';
}
let postTab = document.getElementById('post-tab');
let replyTab = document.getElementById('reply-tab');
let mediaTab = document.getElementById('media-tab');
let likeTab = document.getElementById('like-tab');

postTab.onclick = postTabClick;
replyTab.onclick = replyTabClick;
mediaTab.onclick = mediaTabTabick;
likeTab.onclick = likeTabClick;


document.getElementById('follow-btn').addEventListener('click',function(event){
    event.preventDefault();
    const hiddenValue = document.getElementById('hidden-input').value; // 隠しタグから値を取得
    const csrfHiddenValue = document.getElementById('csrf_token').value; // 隠しタグから値を取得
    let unFollowEle = document.getElementById('un-follow-btn');
    let FollowEle = document.getElementById('follow-btn');
    const postData = {
        user_id: hiddenValue,
        csrf_token: csrfHiddenValue
      }
    
    fetch('/follow', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            //body:JSON.stringify(hiddenValue)
            // body: JSON.stringify(data)
            body: new URLSearchParams(postData).toString()
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status) {
                console.log("成功！！")
                    unFollowEle.style.display = 'block'; 
                    FollowEle.style.display='none'
                
              
            } else {
                
                alert(data.message);
            }
        })
        .catch(error => {
            alert(error);
        });

})

document.getElementById('un-follow-btn').addEventListener('click',function(event){
    event.preventDefault();
    const hiddenValue = document.getElementById('hidden-input').value; // 隠しタグから値を取得
    const csrfHiddenValue = document.getElementById('csrf_token').value; // 隠しタグから値を取得
    let unFollowEle = document.getElementById('un-follow-btn');
    let FollowEle = document.getElementById('follow-btn');
    const postData = {
        user_id: hiddenValue,
        csrf_token: csrfHiddenValue
      }
    
    fetch('/unfollow', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            //body:JSON.stringify(hiddenValue)
            // body: JSON.stringify(data)
            body: new URLSearchParams(postData).toString()
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status) {
                console.log("成功！！")
                    unFollowEle.style.display = 'none'; 
                    FollowEle.style.display='block'
                
              
            } else {
                
                alert(data.message);
            }
        })
        .catch(error => {
            alert(error);
        });

})