
const followList = document.getElementById('follow-list');
const followerList = document.getElementById('follower-list');

function followClick(){
    followList.style.display = 'block';
    followerList.style.display = 'none';
}
function followerClick(){
    followList.style.display = 'none';
    followerList.style.display = 'block';
}

let followTab = document.getElementById('follow-tab');
let followerTab = document.getElementById('follower-tab');

followTab.onclick = followClick;
followerTab.onclick = followerClick;