import bsCustomFileInput from 'bs-custom-file-input';
import tinymce from 'tinymce/tinymce.min.js';

tinymce.baseURL = '/js/tinymce';

tinymce.init({
    selector: 'textarea',
    plugins: 'link lists table image wordcount fullscreen visualblocks searchreplace charmap help',
    toolbar: ['undo redo | formatselect | bold italic frontcolor forecolor backcolor removeformat | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist table link image | fullscreen visualblocks'],
    codesample_global_prismjs: true,
    fullscreen_native: true,
    visualblocks_default_state: true,
    end_container_on_empty_block: true,
    images_upload_url: '/upload',
    file_picker_types: 'image',
    images_file_types: 'jpeg,jpg,png,gif,webp',
    block_unsupported_drop: true,
    height : "450",

    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');
        input.onchange = function() {
            var file = this.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);
                cb(blobInfo.blobUri(), { title: file.name });
            };
        };
        input.click();
    },

    style_formats: [
        { title: 'Headers', items: [
          { title: 'h1', block: 'h1' },
          { title: 'h2', block: 'h2' },
          { title: 'h3', block: 'h3' },
          { title: 'h4', block: 'h4' },
          { title: 'h5', block: 'h5' },
          { title: 'h6', block: 'h6' }
        ] },

        { title: 'Blocks', items: [
          { title: 'p', block: 'p' },
          { title: 'div', block: 'div' },
          { title: 'pre', block: 'pre' }
        ] },

        { title: 'Containers', items: [
          { title: 'section', block: 'section', wrapper: true, merge_siblings: false },
          { title: 'blockquote', block: 'blockquote', wrapper: true },
          { title: 'aside', block: 'aside', wrapper: true },
          { title: 'figure', block: 'figure', wrapper: true }
        ] }
    ]
});

bsCustomFileInput.init();

var title = document.getElementById('title'),
    url = document.getElementById('url');
if (url && title){
    title.addEventListener('keyup', e => {
        url.value = properUrl(e.target.value);
    });
}

function properUrl(url){
    return url.toLowerCase()
        .replaceAll(/[^a-z0-9\-_]/g, '-')
        .replaceAll(/(-)+/g, '-')
        .replaceAll(/^-/g, '')
        .replaceAll(/-$/g, '');
}
