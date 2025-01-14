async function uploadManager() {
    //things to upload
    const file = document.getElementById('file').files[0];
    const thumbnail = document.getElementById('thumbnail').files[0];
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;

    //check if all of them are filled
    if (!file || !title || !description) {
        alert('Please fill all fields');
        return;
    }

    //upload file
    await uploadFile(file, 'files/');

    //upload thumbnail
    if (!thumbnail.type.startsWith('image/')) {
        alert('Thumbnail must be an image');
        return;
    }
    
    //TODO: scale the image to 400x600
    const scaledThumbnail = await scaleImage(thumbnail, 600);
    await uploadFile(scaledThumbnail, 'assets/img/thumbnails/');


    //opload data for table
    const formData = new FormData();
    formData.append('file', file.name);
    formData.append('thumbnail', thumbnail.name);
    formData.append('title', title);
    formData.append('description', description);
    formData.append('file_chunks', Math.ceil(file.size / 900 / 900));
    formData.append('thumbnail_chunks', Math.ceil(scaledThumbnail.size / 900 / 900));

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'uploadManager.php', true); //change the php file
    xhr.send(formData);

    await new Promise(resolve => xhr.onloadend = resolve);
}

async function uploadFile(file, dir) {
    const chunkSize = 900 * 900 //less than 1MB; nemenit lebo vsetko zblbne; dovod Lomen
    const chunks = Math.ceil(file.size / chunkSize);
    console.log(Math.ceil(file.size / chunkSize));
    console.log(`Total chunks: ${chunks}`);
    let uploadedChunks = 0;

    const promises = [];
    for (let i = 0; i < chunks; i++) {
        const start = i * chunkSize;
        const end = Math.min(file.size, start + chunkSize);
        const chunk = file.slice(start, end);

        const formData = new FormData();
        formData.append('file', chunk);
        formData.append('chunkIndex', i);
        formData.append('chunks', chunks);  //total chunks
        formData.append('filename', file.name);
        formData.append('dir', dir);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'upload.php', true);

        xhr.upload.onprogress = function (e) {
            const percent = Math.round((e.loaded / e.total) * 100);
            document.getElementById('progressBar').value = percent;
            document.getElementById('progressBar').innerText = `${percent}%`;
            console.log(`Uploaded ${percent}%`);
        };

        xhr.onload = function () {
            if (xhr.status !== 200) {
                console.error('Upload failed');
            } else {
                uploadedChunks++;
                const overallPercent = Math.round((uploadedChunks / chunks) * 100);
                document.getElementById('progressBar').value = overallPercent;
                document.getElementById('progressBar').innerText = `${overallPercent}%`;
                console.log(`Overall progress: ${overallPercent}%`);
            }
        };

        promises.push(new Promise(resolve => {
            xhr.onloadend = resolve;
        }));

        xhr.send(formData);
    }
    await Promise.all(promises);
}

async function scaleImage(file, targetHeight) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.src = URL.createObjectURL(file);
        img.onload = () => {
            const canvas = document.createElement('canvas');
            const height = targetHeight;
            const width = (img.width / img.height) * height;

            canvas.width = width;
            canvas.height = height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0, width, height);

            canvas.toBlob((blob) => {
                // Create a new file with the same name as the original
                const scaledFile = new File([blob], file.name, { type: file.type });
                resolve(scaledFile);
            }, file.type);
        };
        img.onerror = (err) => {
            reject(err);
        };
    });
}
