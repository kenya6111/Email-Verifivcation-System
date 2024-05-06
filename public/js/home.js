
const trendContent = document.getElementById('trend-content');
const followerContent = document.getElementById('follower-content');

function trendClick(){
    trendContent.style.display = 'block';
    followerContent.style.display = 'none';
}
function followClick(){
    trendContent.style.display = 'none';
    followerContent.style.display = 'block';
}

let trendButton = document.getElementById('trend-btn');
let followButton = document.getElementById('follow-btn');

trendButton.onclick = trendClick;
followButton.onclick = followClick;

// document.getElementById('send-form').addEventListener('submit',function(event){
//     event.preventDefault();

//     let fileInput=document.querySelector("#file-upload");
//     const formData = new FormData();
//     formData.append('file-upload',fileInput.files[0]);

//     fetch('/form/post', {
//             method: 'POST',
//             body: formData,
//         })
//         .then(response => {
//             if (!response.ok) {
//                 throw new Error(`HTTP error! Status: ${response.status}`);
//             }
//             return response.json();
//         })
//         .then(data => {
//             if (data.success) {

//                 const posts = data.post;


//                 const container = document.getElementById('list-group');
//                 container.innerHTML = '';

//                 posts.forEach(post => {
//                     const postElement = document.createElement('li');
//                     postElement.classList.add('post');

//                     const subjectElement = document.createElement('h2');
//                     subjectElement.textContent=post.subject;
//                     postElement.appendChild(subjectElement);

//                     const contentElement = document.createElement('p');
//                     contentElement.textContent = post.content;
//                     postElement.appendChild(contentElement);

//                     const aElement = document.createElement('a');
//                     aElement.setAttribute('href', post.url);

//                     const imageElement = document.createElement('img');
//                     imageElement.src = '/uploads/' + post.file_path;
//                     imageElement.alt = post.subject; 
//                     aElement.appendChild(imageElement);
//                     postElement.appendChild(aElement);


//                     container.appendChild(postElement);
//                 })
              
//             } else {
                
//                 alert(data.message);
//             }
//         })
//         .catch(error => {
//             alert(error);
//         });

// })

