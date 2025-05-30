document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.custom-like-button').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            fetch(`/wp-json/lance/v1/like/${postId}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                const likeCountEl = document.getElementById(`like-count-${postId}`);
                if (likeCountEl) {
                    likeCountEl.textContent = data.likes;
                }
            })
            .catch(err => console.error('Like error:', err));
        });
    });
});
