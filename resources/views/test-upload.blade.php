<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Video Upload</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        button {
            padding: 10px 15px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        #result {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
            display: none;
        }
        #progress-bar {
            height: 20px;
            background-color: #f0f0f0;
            margin: 10px 0;
            border-radius: 4px;
            overflow: hidden;
        }
        #progress {
            height: 100%;
            background-color: #4CAF50;
            width: 0%;
            transition: width 0.3s;
        }
    </style>
</head>
<body>
    <h1>Test Video Upload</h1>
    <p>Sử dụng form này để kiểm tra việc tải lên video.</p>

    <div class="form-group">
        <label for="video">Chọn file video:</label>
        <input type="file" id="video" name="video" accept="video/mp4,video/avi,video/mov">
    </div>

    <div id="progress-bar">
        <div id="progress"></div>
    </div>

    <button type="button" onclick="uploadVideo()">Tải lên</button>

    <div id="result"></div>

    <script>
        function uploadVideo() {
            const videoFile = document.getElementById('video').files[0];
            const resultDiv = document.getElementById('result');
            const progressBar = document.getElementById('progress');

            if (!videoFile) {
                resultDiv.style.display = 'block';
                resultDiv.innerHTML = 'Vui lòng chọn file video trước.';
                return;
            }

            const formData = new FormData();
            formData.append('video', videoFile);
            formData.append('_token', '{{ csrf_token() }}');

            resultDiv.style.display = 'block';
            resultDiv.innerHTML = 'Đang tải lên...';

            axios.post('/test-upload', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: (progressEvent) => {
                    const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressBar.style.width = percentCompleted + '%';
                }
            })
            .then(response => {
                resultDiv.innerHTML = '<pre>' + JSON.stringify(response.data, null, 2) + '</pre>';
            })
            .catch(error => {
                resultDiv.innerHTML = 'Error: ' + (error.response?.data?.message || error.message);
                console.error('Upload error:', error);
            });
        }
    </script>
</body>
</html>
