function executeCopy(btn) {
    const codeBlock = btn.parentElement.nextElementSibling.querySelector('code');
    const textToCopy = codeBlock.innerText;

    navigator.clipboard.writeText(textToCopy).then(() => {
        btn.innerText = "Copied!";
        btn.classList.add('copied');
        setTimeout(() => {
            btn.innerText = "Copy";
            btn.classList.remove('copied');
        }, 2000);
    }).catch(err => {
        console.error('Failed to copy: ', err);
    });
}
