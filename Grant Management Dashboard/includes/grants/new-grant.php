<head>
<script type="text/javascript">
let dragarea = document.getElementById('drag-and-drop');
let fileInput = document.getElementById('file-upload');

dragarea.addEventListener('dragover', (e) => {
  e.preventDefault();
  dragarea.classList.add('dragging');
});

dragarea.addEventListener('dragleave', () => {
  dragarea.classList.remove('dragging');
});

dragarea.addEventListener('drop', (e) => {
  e.preventDefault();
  dragarea.classList.remove('dragging');
  fileInput.files = e.dataTransfer.files;
  readSingleFile(e);
  //console.log(e);
});

</script>
</head>
<div class="full-card">
  <div class="card-title">
    <div class="card-title-text">
      <i class="fas fa-plus-circle"></i><span class="parent-link">New Grant</span>
    </div>
    <div class="card-title-button">
    </div>
  </div>

  <div class="card-body">
    <div class="input-grant-title">
      <p>Grant Name</p>
      <input type="text" id="input-title" class="input-text">
    </div>
    <div class="input-grant-description">
      <p>Budget Purpose</p>
      <input type="text" id="input-bp" class="input-text">
    </div>
    <div class="drag-and-drop-description">
      <p>Upload Excel Data</p><span class="small-hint">(.xlsx format)</span>
    </div>
    <div id="drag-and-drop" class="drag-and-drop">
      <div class="drag-and-drop-text">
        <p>Drag and Drop File Here</p>
      </div>
      <div class="drag-and-drop-text-or">
        <p>or</p>
      </div>
      <label for="file-upload" class="custom-file-upload">
          Select File
      </label>
      <input id="file-upload" type="file"/>
    </div>
  </div>
</div>
