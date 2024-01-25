let likeCount = 0

function toggleEdit(postId) {

    const postList = document.querySelectorAll('article.post')
    const editList = document.querySelectorAll('article.edit')

    postList.forEach(post =>
    {
        let id = (post.id)
        id = id.split('-')[1]

        if (id == postId) {
            post.hidden = !post.hidden
        } else post.hidden = false
    })

    editList.forEach(post => {

        let id = (post.id)
        id = id.split('-')[1]

        if (id == postId) {
        post.hidden = !post.hidden
        } else post.hidden = true
    })
}

function handleLike(postId) {

    const likedPost = document.getElementById('img-like-icon-' + postId)
    const nbrLikes = document.getElementById('post-likes-' + postId)
    console.log(likedPost.src)

    if (likedPost.src === "http://learn.test/icons/like_icon.png") {
        likedPost.src = "../icons/like_fill_icon.png"
        let newNbrLikes = Number(nbrLikes.innerHTML) + 1
        nbrLikes.innerHTML = newNbrLikes.toString()
        likeCount = 1
    } else {
        likedPost.src = "http://learn.test/icons/like_icon.png"
        let newNbrLikes = Number(nbrLikes.innerHTML) - 1
        nbrLikes.innerHTML = newNbrLikes.toString()
        likeCount = -1
    }

    const likes = {likeCount: likeCount, postId: postId}

    fetch("/post/like", {
        method: "POST",
        headers: {"Content-type": "application/json; charset=UTF-8"},
        body: JSON.stringify(likes)
    })


}