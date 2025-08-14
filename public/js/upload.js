let uploadInput = document.getElementById('doc-upload');
let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const baseUrl = 'http://localhost:8000';

async function uploadImage(image) {
    let data = new FormData();
    data.append('document', image);

    await fetch(`${baseUrl}/upload`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: data,
    }).then(async (response) => {
        if (!response.ok) {
            console.log('Image upload request failed.');
            return;
        }

        let result = await response.text();

        // Simple upload success message
        if (result === 'Success') {
            let successElem = document.querySelector('.upload-success-msg');
            successElem.classList.remove('hidden');
            setTimeout(() => {
                if (!successElem.classList.contains('hidden')) {
                    successElem.classList.add('hidden');
                }
            }, 2000);
        }

        console.log('Image upload request: ' + result);
    }).catch((error) => {
        console.log('Image upload request failed...', error);
    });
}

uploadInput.addEventListener('change', () => {
    uploadImage(uploadInput.files[0]);
});
