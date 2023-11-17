var csrfToken = document.documentElement.dataset.csrf;

function confirmDeletePost(postId) {
    if (confirm('Are you sure you want to delete this post?')) {
        document.getElementById('delete-form-' + postId).submit();
    }
}

function showCommentPopup(postId) {
    
    var modal = document.getElementById("commentSection-" + postId);
    modal.classList.toggle("hidden"); // Toggle the 'hidden' class to show/hide the modal
    getComments(postId);
}

function confirmDeleteComment(commentId, postId) {
    if (confirm("Are you sure you want to delete this comment?")) {
        $.ajax({
            url: `/delete-comment/${commentId}`,
            method: "DELETE",
            data: {
                _token: csrfToken,
            },
            success: function (response) {
                getComments(postId);
            },
            error: function (error) {
                // Handle any errors here (if needed)
                console.error(error);
            },
        });
    }
}



function updateReactionCount(postId, reactionType) {
    $.ajax({
        url: `/reaction-count/${postId}/${reactionType}`,
        method: "GET",
        success: function(response) {
            $(`#reaction-count-${reactionType}-${postId}`).text(response.count);
        },
        error: function(error) {
            console.error(error);
            // Handle errors here (e.g., display an error message)
        },
    });
}


function react(postId, reactionType, color, button) {
    // Toggle the button's color immediately
    $(button).toggleClass(`text-gray-500 text-${color}`);

    // Send an AJAX request to the respective reaction route
    $.ajax({
        url: `/${reactionType}React/${postId}`,
        method: "POST",
        data: {
            _token: csrfToken
        },
        success: function(response) {
            // Handle any success response here (if needed)
            console.log(response);
        },
        error: function(error) {
            // Handle any errors here (if needed)
            console.error(error);
            // Revert the button's color if there was an error
            $(button).toggleClass(`text-${color} text-gray-500`);
        },
    });
    updateReactionCount(postId, reactionType);
}

function submitComment(postId, form) {
    // Prevent the default form submission
    event.preventDefault();

    // Get the content value
    const content = form.querySelector('input[name="content"]').value;

    // Send an Ajax request to submit the comment
    $.ajax({
        url: `/submitComment/${postId}`,
        method: "POST",
        data: {
            _token: csrfToken,
            content: content // Include the content in the data object
        },
        success: function (response) {
            $('input[name="content"]').val('');
            getComments(postId);
        },
        error: function (error) {
            // Handle any errors here (if needed)
            console.error(error);
        },
    });

    // Return false to prevent the form from being submitted
    return false;
}

function getComments(postId) {
    $.ajax({
        type: 'GET',
        url: `/comments/${postId}`,
        data: {
            _token: csrfToken,
        },
        success: function (data) {
            // Clear existing comments in the container
            $('#comments-container-' + postId).empty();

            // Loop through the comments and append them to the container
            data.comments.forEach(function(comment) {
                var userName = comment.user_name;
                var userAvatar = comment.user_avatar;
            
                // Combine the base URL with the avatar path
                var fullAvatarPath = '/images/' + userAvatar;
            
                // Apply styles directly within the HTML string
                var commentHtml = `<div class="comment-container max-w-md mx-auto mb-4 p-4 border rounded bg-gray-100">
                                        <div class="flex items-center mb-2">
                                            <img src="${fullAvatarPath}" alt="User Avatar" style="width: 35px; height: 35px; object-fit: cover;" class="rounded-full border border-gray-300 mr-2">
                                            <span class="font-bold text-gray-800">${userName}</span>`;
            
                if (data.user && comment.user_id === data.user.id) {
                    commentHtml += `<button onclick="confirmDeleteComment(${comment.id}, ${postId})" style="cursor: pointer; margin-left: auto;" class="material-symbols-outlined text-red-600">Delete</button>`;
                }
            
                commentHtml += `</div>
                                        
                                            <div class="text-md break-words w-full text-gray-700">
                                                ${comment.content}
                                            </div>
                                   
                                    </div>`;
            
                var commentsContainerId = '#comments-container-' + postId;
                $(commentsContainerId).append(commentHtml);
            });
            
            
            
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}














