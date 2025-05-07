<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terabox Video Downloader</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #1c1c1c;
      color: #f0f0f0;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
      padding: 20px;
    }
    h2 {
      color: #ffffff;
      margin-bottom: 20px;
      text-align: center;
      font-size: 28px;
    }
    input {
      padding: 12px;
      width: 90%;
      max-width: 500px;
      border-radius: 8px;
      border: 1px solid #444;
      background-color: #333;
      color: #fff;
      font-size: 16px;
      margin-bottom: 20px;
    }
    button {
      padding: 12px 24px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #0056b3;
    }
    #message {
      margin-top: 20px;
      color: red;
      text-align: center;
    }
    #downloadSection {
      display: none;
      margin-top: 20px;
      text-align: center;
      background-color: #333;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
    }
    #downloadSection img {
      max-width: 150px;
      border-radius: 8px;
      margin-bottom: 10px;
    }
    #downloadBtn {
      padding: 12px 24px;
      background-color: #28a745;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    #downloadBtn:hover {
      background-color: #218838;
    }
    /* Popup Overlay */
    #popupOverlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.8);
      z-index: 1000;
      align-items: center;
      justify-content: center;
    }
    #popup {
      background: #2c2c2c;
      padding: 30px;
      border-radius: 8px;
      text-align: center;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.5);
    }
    #popup h3 {
      margin-bottom: 15px;
      color: #f0f0f0;
    }
    #popup p {
      margin-bottom: 20px;
      color: #bbb;
    }
    #closePopupBtn {
      background-color: #dc3545;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }
    #closePopupBtn:hover {
      background-color: #c82333;
    }
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
      h2 {
        font-size: 22px;
      }
      input, button {
        width: 100%;
        max-width: 90%;
      }
    }
  </style>
</head>
<body>
  <h2>Terabox Video Downloader🔥</h2>
  <input type="text" id="urlInput" placeholder="টেরাবক্স শেয়ার লিংক দিন...">
  <button onclick="downloadVideo()">Download </button>
  <div id="message"></div>

  <div id="downloadSection">
    <img id="thumbnail" src="" alt="Video Thumbnail">
    <h3 id="videoTitle"></h3>
    <p id="videoSize"></p>
    <button id="downloadBtn" onclick="startDownload()">ডাউনলোড ভিডিও</button>
  </div>

  <!-- Popup for confirmation -->
  <div id="popupOverlay">
    <div id="popup">
      <h3>ভিডিও ডাউনলোড করতে যাচ্ছেন</h3>
      <p>আপনি কি নিশ্চিত যে আপনি ভিডিওটি ডাউনলোড করতে চান?</p>
      <button id="closePopupBtn" onclick="closePopup()">বাতিল</button>
    </div>
  </div>

  <script>
    async function downloadVideo() {
      const inputUrl = document.getElementById("urlInput").value.trim();
      const message = document.getElementById("message");
      message.textContent = "";

      if (!inputUrl) {
        message.textContent = "দয়া করে টেরাবক্স লিংক দিন।";
        return;
      }

      const apiUrl = "terabox_downloader.php?url=" + encodeURIComponent(inputUrl);

      try {
        const res = await fetch(apiUrl);
        const data = await res.json();

        if (data.status === "success") {
          const downloadLink = data.data.downloadUrl;
          const thumbnail = data.data.thumbnail;
          const title = data.data.title;
          const size = data.data.size;

          // Show the download section with video details
          document.getElementById("thumbnail").src = thumbnail;
          document.getElementById("videoTitle").textContent = title;
          document.getElementById("videoSize").textContent = size;
          document.getElementById("downloadBtn").setAttribute("data-download", downloadLink);

          document.getElementById("downloadSection").style.display = "block";
        } else {
          message.textContent = data.message || "ডাউনলোডে সমস্যা হয়েছে।";
        }
      } catch (err) {
        message.textContent = "সার্ভার থেকে ডেটা পাওয়া যায়নি।";
        console.error(err);
      }
    }

    function startDownload() {
      // Show confirmation popup
      document.getElementById("popupOverlay").style.display = "flex";
    }

    function closePopup() {
      // Close the popup overlay
      document.getElementById("popupOverlay").style.display = "none";
    }

    // Proceed to download if confirmed
    document.getElementById("downloadBtn").addEventListener("click", function () {
      const downloadLink = document.getElementById("downloadBtn").getAttribute("data-download");

      // Create an invisible link to trigger download
      const a = document.createElement("a");
      a.href = downloadLink;
      a.download = true;

      // Append the link to the body, trigger a click and then remove it
      document.body.appendChild(a);
      a.click();
      document.body.removeChild(a);

      // Close the popup after download is started
      closePopup();
    });
  </script>
</body>
</html>
