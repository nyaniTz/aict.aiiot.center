<!DOCTYPE html>
<html>
<head>
  <title>Email Sender</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap CSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .swal2-title {
      color: #f03c02 !important;
    }
    .swal2-confirm {
      background-color: #f03c02 !important;
    }
  </style>

</head>
<body>
  <button id="openModalBtn" class="btn btn-primary">Open Modal</button>
  
  <script>
   document.getElementById('openModalBtn').addEventListener('click', function() {
  Swal.fire({
    title: 'Submit Paper',
    html:
      '<input id="subjectInput" class="form-control mb-3" placeholder="Write Your Name" required>' +
      '<textarea id="bodyInput" class="form-control mb-3" placeholder="Body" required></textarea>' +
      '<div class="input-group mb-3">' +
      '<input type="file" id="attachmentInput" class="form-control" accept=".doc,.docx,.pdf" required>' +
      '<label class="input-group-text" for="attachmentInput"><i class="bi bi-file-earmark-arrow-up"></i></label>' +
      '</div>' +
      '<p id="error" style="color:#f03c02;display:none"></p>',
    focusConfirm: false,
    preConfirm: () => {
      const subject = document.getElementById('subjectInput').value;
      const body = document.getElementById('bodyInput').value;
      const attachmentFile = document.getElementById('attachmentInput').files[0];

      if (!subject) {
        document.getElementById('error').textContent = 'Please write your name';
        document.getElementById('error').style.display = 'block';
        return false;
      }

      if (!attachmentFile) {
        document.getElementById('error').textContent = 'Please choose a file';
        document.getElementById('error').style.display = 'block';
        return false;
      }

      const attachmentBlob = new Blob([attachmentFile], {type: attachmentFile.type});
      attachmentBlob.lastModifiedDate = attachmentFile.lastModifiedDate;
      attachmentBlob.name = attachmentFile.name;

      return {
        subject: subject,
        body: body,
        attachment: attachmentBlob
      }
    }
  }).then((result) => {
    if (result.isConfirmed) {
      const formData = new FormData();
      formData.append('to', 'nyoxmlimwa@gmail.com');
      formData.append('subject', result.value.subject);
      formData.append('body', result.value.body);
      formData.append('attachment', result.value.attachment, result.value.attachment.name);

      const xhr = new XMLHttpRequest();
      xhr.open('POST', 'send_email.php');
      xhr.onload = function() {
        if (xhr.status === 200) {
          Swal.fire('Email Sent', 'The email has been sent successfully.', 'success');
        } else {
          Swal.fire('Error', 'Failed to send the email. Please try again later.', 'error');
        }
      };
      xhr.send(formData);
    }
  });
});


  </script>
</body>
</html>
