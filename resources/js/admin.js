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

window.onload = function(){
    let changePassword = document.getElementById('change_password');

    if  (changePassword){
        changePassword.addEventListener('click', function(){
            var el = document.getElementById('password-group');
            if (this.checked)
                el.classList.remove('d-none');
            else el.classList.add('d-none');
        });
    }
}
