import tinymce from 'tinymce/tinymce.min.js';

tinymce.baseURL = '/js/tinymce';

const editorConfig = {
    path_absolute: 'http://admin.laravel-blog.test/',
    selector: 'textarea',

    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table directionality",
        "emoticons template paste textpattern"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
    fullscreen_native: true,
    visualblocks_default_state: false,
    end_container_on_empty_block: true,
    block_unsupported_drop: true,
    relative_urls: false,
    height: "450",

    file_picker_callback: function(callback, value, meta){
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editorConfig.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
        if (meta.filetype == 'image') {
            cmsURL = cmsURL + "&type=Images";
        }
        else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinymce.activeEditor.windowManager.openUrl({
            url: cmsURL,
            title: 'Filemanager',
            width: x * 0.8,
            height: y * 0.8,
            resizable: "yes",
            close_previous: "no",
            onMessage: (api, message) => {
                callback(message.content);
            }
        });
    },

    style_formats: [
        { title: 'Headers', items: [
          { title: 'h1', block: 'h1' },
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
};

tinymce.init(editorConfig);
