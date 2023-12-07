

function toggleToEdit(e, postId) {

    const eventId = e.target.id.split('-')[2]

    if (eventId == postId) {
        document.getElementById(`post-${postId}`).classList.toggle('hidden')
        document.getElementById(`edit-${postId}`).classList.toggle('hidden')
    }

}