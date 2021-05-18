const title = document.getElementById('title'),
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
