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