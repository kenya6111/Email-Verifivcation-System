
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