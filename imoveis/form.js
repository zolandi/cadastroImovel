function selectOnlyThis(id){
    var tipo = document.getElementsByName("estado");
    Array.prototype.forEach.call(tipo,function(el){
        el.checked = false;
    });
    id.checked = true;
  }

  function previewImage(event) {
    var reader = new FileReader();
    var preview = document.getElementById('imgPreview');

    reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block'; // Show the preview image
    };

    if (event.target.files[0]) {
        reader.readAsDataURL(event.target.files[0]);
    }
  }