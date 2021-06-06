const checkbox = document.querySelector('#is_visible');
const inputs = document.querySelector('#release-inputs');

function changeInputs(value){
    if (value)
        inputs.classList.add('d-none');
    else inputs.classList.remove('d-none');
}

if (checkbox && inputs){
    changeInputs(checkbox.checked);

    checkbox.addEventListener('change', function(e){
        changeInputs(e.target.checked);
    });
}
