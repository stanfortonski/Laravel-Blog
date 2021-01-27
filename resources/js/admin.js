import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import bsCustomFileInput from 'bs-custom-file-input';
import config from './config';

bsCustomFileInput.init();

var textareas = document.querySelector('.textarea-ckeditor');
if (textareas){
    ClassicEditor.create(textareas, config)
    .catch(err => {
        console.error(err);
    });
}

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
