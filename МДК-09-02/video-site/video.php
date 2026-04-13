<?php
// video.php - С записью видео
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit();
}

$visitors = loadVisitors();
$videoFile = 'videos/sample.mp4';
$videoExists = file_exists($videoFile);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видео стрим</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .header {
            background: white;
            border-radius: 15px;
            padding: 20px 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .username {
            font-weight: 600;
            color: #667eea;
            font-size: 18px;
        }
        
        .logout-btn {
            padding: 8px 20px;
            background: #f0f0f0;
            color: #666;
            text-decoration: none;
            border-radius: 8px;
        }
        
        .video-container {
            background: white;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        
        .video-wrapper {
            position: relative;
            width: 100%;
            background: #000;
            border-radius: 15px;
            overflow: hidden;
            aspect-ratio: 16/9;
        }
        
        #mainVideo {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background: #000;
        }
        
        #cameraFeed {
            display: none;
        }
        
        .controls {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }
        
        .btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-red {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        }
        
        .btn-green {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
        }
        
        .status {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .status.recording {
            background: #fee;
            color: #c33;
            animation: pulse 1.5s infinite;
        }
        
        .status.success {
            background: #e8f5e9;
            color: #2e7d32;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .recordings-list {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
        }
        
        .recordings-list h3 {
            margin-bottom: 20px;
            color: #333;
        }
        
        .recording-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .recording-item a {
            color: #667eea;
            text-decoration: none;
        }
        
        .visitors-list {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
        }
        
        .visitor-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            border-bottom: 1px solid #f0f0f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="user-info">
                <span class="username">👤 <?php echo htmlspecialchars($_SESSION['user']); ?></span>
                <span id="cameraStatus">📷 Камера не активна</span>
                <a href="logout.php" class="logout-btn">Выйти</a>
            </div>
        </div>
        
        <div class="video-container">
            <div id="statusMessage" class="status success">
                ✅ Готов к записи
            </div>
            
            <div class="video-wrapper">
                <?php if ($videoExists): ?>
                    <video id="mainVideo" controls preload="auto">
                        <source src="<?php echo $videoFile; ?>" type="video/mp4">
                    </video>
                <?php else: ?>
                    <div style="padding: 200px; text-align: center; color: white;">
                        Видео не найдено
                    </div>
                <?php endif; ?>
            </div>
            
            <video id="cameraFeed" autoplay playsinline muted></video>
            
            <div class="controls">
                <button id="startCamera" class="btn btn-green" onclick="startCamera()">📷 Включить камеру</button>
                <button id="startRecord" class="btn btn-red" onclick="startRecording()" disabled>⏺ Начать запись</button>
                <button id="stopRecord" class="btn" onclick="stopRecording()" disabled>⏹ Остановить запись</button>
            </div>
        </div>
        
        <div class="recordings-list">
            <h3>📁 Записи с камер пользователей</h3>
            <div id="recordingsList">
                <?php
                $recordingsDir = 'recordings/';
                if (file_exists($recordingsDir)) {
                    $files = array_diff(scandir($recordingsDir), array('.', '..'));
                    foreach ($files as $file) {
                        $filepath = $recordingsDir . $file;
                        $filesize = round(filesize($filepath) / 1024 / 1024, 2);
                        echo '<div class="recording-item">';
                        echo '<a href="' . $filepath . '" target="_blank">🎥 ' . $file . '</a>';
                        echo '<span>' . $filesize . ' MB</span>';
                        echo '</div>';
                    }
                }
                ?>
            </div>
        </div>
        
        <div class="visitors-list">
            <h3>📊 Посетители</h3>
            <?php foreach(array_reverse($visitors) as $visitor): ?>
                <div class="visitor-item">
                    <span><?php echo $visitor['username']; ?></span>
                    <span><?php echo $visitor['timestamp']; ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
        let cameraStream = null;
        let mediaRecorder = null;
        let recordedChunks = [];
        const username = '<?php echo $_SESSION['user']; ?>';
        
        const cameraFeed = document.getElementById('cameraFeed');
        const statusMessage = document.getElementById('statusMessage');
        const cameraStatus = document.getElementById('cameraStatus');
        const startCameraBtn = document.getElementById('startCamera');
        const startRecordBtn = document.getElementById('startRecord');
        const stopRecordBtn = document.getElementById('stopRecord');
        
        async function startCamera() {
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({ 
                    video: true, 
                    audio: false 
                });
                
                cameraFeed.srcObject = cameraStream;
                cameraStatus.innerHTML = '📷 Камера активна';
                cameraStatus.style.color = '#27ae60';
                
                startCameraBtn.disabled = true;
                startRecordBtn.disabled = false;
                
                statusMessage.className = 'status success';
                statusMessage.innerHTML = '✅ Камера включена. Можно начинать запись';
                
            } catch (error) {
                statusMessage.className = 'status recording';
                statusMessage.innerHTML = '❌ Ошибка доступа к камере';
            }
        }
        
        function startRecording() {
            if (!cameraStream) return;
            
            recordedChunks = [];
            mediaRecorder = new MediaRecorder(cameraStream, {
                mimeType: 'video/webm'
            });
            
            mediaRecorder.ondataavailable = (event) => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };
            
            mediaRecorder.onstop = saveRecording;
            
            mediaRecorder.start();
            
            statusMessage.className = 'status recording';
            statusMessage.innerHTML = '⏺ ИДЁТ ЗАПИСЬ...';
            
            startRecordBtn.disabled = true;
            stopRecordBtn.disabled = false;
        }
        
        function stopRecording() {
            if (mediaRecorder && mediaRecorder.state !== 'inactive') {
                mediaRecorder.stop();
            }
            
            statusMessage.className = 'status success';
            statusMessage.innerHTML = '⏹ Запись остановлена. Сохранение...';
            
            startRecordBtn.disabled = false;
            stopRecordBtn.disabled = true;
        }
        
        function saveRecording() {
            const blob = new Blob(recordedChunks, { type: 'video/webm' });
            const formData = new FormData();
            
            const filename = `${username}_${new Date().toISOString().slice(0,19).replace(/:/g, '-')}.webm`;
            formData.append('video', blob, filename);
            
            fetch('save_recording.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                statusMessage.innerHTML = '✅ Запись сохранена!';
                loadRecordingsList();
            })
            .catch(error => {
                statusMessage.innerHTML = '❌ Ошибка сохранения';
            });
        }
        
        function loadRecordingsList() {
            location.reload();
        }
    </script>
</body>
</html>