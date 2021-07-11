const hiddenForm = document.querySelector('.hidden-form');
const hiddenFormInfo = document.querySelector('.hidden-form-info');
const hiddenFormInfoButton = document.querySelector('.hidden-form-info button');

if (hiddenForm && hiddenFormInfo && hiddenFormInfoButton){
    hiddenFormInfoButton.addEventListener('click', () => {
        hiddenForm.classList.remove('d-none');
        hiddenFormInfo.classList.add('d-none');
    });
}
