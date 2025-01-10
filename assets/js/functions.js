async function uploadFile() {
    //things to upload
    const file = document.getElementById('file').files[0];
    const title = document.getElementById('title').value;
    const description = document.getElementById('description').value;

    //check if all of them are filled
    if (!file || !title || !description) {
        alert('Please fill all fields');
        return;
    }

    const chunkSize = 900 * 900 //less than 1MB
    const chunks = Math.ceil(file.size / chunkSize);
    console.log(Math.ceil(file.size / chunkSize));
    console.log(`Total chunks: ${chunks}`);
    let uploadedChunks = 0;

    for (let i = 0; i < chunks; i++) {
        const start = i * chunkSize;
        const end = Math.min(file.size, start + chunkSize);
        const chunk = file.slice(start, end);

        const formData = new FormData();
        formData.append('file', chunk);
        formData.append('chunkIndex', i);
        formData.append('chunks', chunks);  //total chunks
        formData.append('filename', file.name);

        //other form data
        formData.append('title', title); 
        formData.append('description', description);

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

        xhr.send(formData);
        await new Promise(resolve => xhr.onloadend = resolve);
    }
}