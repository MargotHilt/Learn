let likeCount = 0

function toggleEdit(status, postId) {

    const postList = document.querySelectorAll('article.post')
    const editList = document.querySelectorAll('article.edit')

    postList.forEach(post =>
    {
        let id = (post.id)
        id = id.split('-')[1]

        if(id == postId && status === 'noEdit') {
            post.hidden = true
        } else post.hidden = false
    })

    editList.forEach(post => {

        let id = (post.id)
        id = id.split('-')[1]

        if(id == postId && status === 'noEdit') {
        post.hidden = false
        } else post.hidden = true
    })
}

function handleLike(postId) {

    const likedPost = document.getElementById('img-like-icon-' + postId)
    console.log(likedPost.src)

    if (likedPost.src === "http://learn.test/asset/like_icon.png") {
        likedPost.src = "../asset/like_fill_icon.png"
        likeCount = 1
    } else {
        likedPost.src = "http://learn.test/asset/like_icon.png"
        likeCount = -1
    }

    const likes = {likeCount: likeCount, postId: postId}

    fetch("/dashboard/post/like", {
        method: "POST",
        headers: {"Content-type": "application/json; charset=UTF-8"},
        body: JSON.stringify(likes)
    })


}