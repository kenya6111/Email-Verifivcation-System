document.querySelectorAll('.notice').forEach(post => {
    post.addEventListener('click', function() {
        window.location.href = this.getAttribute('data-url');
    });
});