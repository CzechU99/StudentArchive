function generateComments(commentsData) {
  var commentsContainer = document.getElementById("commentsContainer");

  // Przechodzimy przez dane komentarzy i tworzymy dla każdego komentarza odpowiednią strukturę HTML
  commentsData.forEach(comment => {
    var commentDiv = document.createElement("div");
    commentDiv.classList.add("list-group-item", "list-group-item-action", "commentField");

    var headerDiv = document.createElement("div");
    headerDiv.classList.add("d-flex", "justify-content-between");

    var username = document.createElement("h5");
    username.classList.add("mb-1");
    username.textContent = comment.user_email;

    var date = document.createElement("small");
    date.classList.add("text-muted");
    date.textContent = comment.date;

    headerDiv.appendChild(username);
    headerDiv.appendChild(date);

    var contentParagraph = document.createElement("p");
    contentParagraph.classList.add("mb-1");
    contentParagraph.textContent = comment.comment_content;

    var deleteButton = document.createElement("button");
    deleteButton.classList.add("btn", "btn-danger", "btn-sm", "align-self-end");
    deleteButton.textContent = "Usuń";

    commentDiv.appendChild(headerDiv);
    commentDiv.appendChild(contentParagraph);
    //commentDiv.appendChild(deleteButton);

    commentsContainer.insertBefore(commentDiv, commentsContainer.firstChild);
  });
}

$(document).ready(function () {
  $('#commentsModal').on('show.bs.modal', function (event) {
    var triggerElement = $(event.relatedTarget);

    var fileName = triggerElement.data('file-name');
    var fileOwner = triggerElement.data('user-id');

    $('#newCommentButton').data('file-name', fileName);
    $('#newCommentButton').data('user-id', fileOwner);

    var commentedFile = {
      name: fileName,
      owner: fileOwner
    };

    fetch('Functions/main/loadComments.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(commentedFile),
    })
    .then(response => response.json())
    .then(data => {
      console.log(data);
      generateComments(data);
    })
    .catch(error => {
      console.error('Wystąpił błąd podczas pobierania danych z serwera PHP: ', error);
    });
  });

  // Deklaracja handlera submit poza handlerem 'show.bs.modal'
  $('#newCommentForm').submit(function (event) {
    event.preventDefault();

    var commentContent = $('#newComment').val().trim();
    if (commentContent === '') {
      alert('Komentarz nie może być pusty!');
      return;
    }

    var fileInfo = $('#newCommentButton');
    var fileName = fileInfo.data('file-name');
    var fileOwner = fileInfo.data('user-id');

    now = new Date();
    commentContent += ` |      Dodano: ${now.getDate()} . ${now.getMonth()+1} . ${now.getFullYear()}`;

    var formData = {
      comment_content: commentContent,
      file_name: fileName,
      file_owner: fileOwner
    };

    $.ajax({
      type: 'POST',
      url: 'Functions/main/comments.php',
      data: formData,
      success: function (response) {
        console.log('Komentarz dodany:', response);
        $('#newComment').val('');
        $('#commentsModal').modal('hide');
      },
      error: function () {
        alert('Wystąpił błąd przy dodawaniu komentarza.');
      }
    });
  });

  $('#commentsModal').on('hide.bs.modal', function () {
    $(this).find('.commentField').remove();
  });
});
