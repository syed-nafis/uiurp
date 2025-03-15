document.getElementById('submitPost').addEventListener('click', function() {
    const postTitle = document.getElementById('postTitle').value.trim();
    const postContent = document.getElementById('postContent').value.trim();

    if (postTitle === '' || postContent === '') {
        alert('Please fill in both fields!');
        return;
    }

    const postsContainer = document.getElementById('postsContainer');
    const postDiv = document.createElement('div');
    postDiv.classList.add('post');

    const titleElement = document.createElement('h2');
    titleElement.textContent = postTitle;

    const contentElement = document.createElement('p');
    contentElement.textContent = postContent;

    const voteButtons = document.createElement('div');
    voteButtons.classList.add('vote-buttons');

    const upvoteButton = document.createElement('button');
    upvoteButton.textContent = 'Upvote';
    upvoteButton.addEventListener('click', function() {
        alert('Post upvoted!');
    });

    const downvoteButton = document.createElement('button');
    downvoteButton.textContent = 'Downvote';
    downvoteButton.addEventListener('click', function() {
        alert('Post downvoted!');
    });

    voteButtons.appendChild(upvoteButton);
    voteButtons.appendChild(downvoteButton);
    postDiv.appendChild(titleElement);
    postDiv.appendChild(contentElement);
    postDiv.appendChild(voteButtons);
    postsContainer.appendChild(postDiv);

    document.getElementById('postTitle').value = '';
    document.getElementById('postContent').value = '';
});