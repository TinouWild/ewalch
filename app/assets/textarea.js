function autoResizeTextarea() {
    let textarea = document.getElementById('autoResizeTextarea');
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
}

document.getElementById('autoResizeTextarea').addEventListener('input', autoResizeTextarea);

window.addEventListener('load', autoResizeTextarea);
