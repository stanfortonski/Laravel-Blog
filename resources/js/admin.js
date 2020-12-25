import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import bsCustomFileInput from 'bs-custom-file-input';
import config from './config';

bsCustomFileInput.init();

let textareas = document.querySelector('.textarea-ckeditor');
if (textareas){
    ClassicEditor.create(textareas, config)
    .catch(err => {
        console.error(err);
    });
}
