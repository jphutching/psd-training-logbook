<?php 
require_once 'includes/db_connect.php'; 
checkLogin(); // Redirects to login.php if not authenticated
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="theme-color" content="#0d6efd">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Entry | Otis Logbook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7f6; padding-bottom: 50px; }
        .card { border-radius: 15px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .btn-check:checked + .btn-outline-primary { background-color: #0d6efd; color: white; border-color: #0d6efd; }
        .header-box { background: #0d6efd; color: white; padding: 20px; border-radius: 0 0 20px 20px; margin-bottom: 25px; }
    </style>
</head>
<body>

    <div class="header-box text-center">
        <h2>🐾 New Training Log</h2>
        <p class="mb-0">Logged in as: <?= htmlspecialchars($_SESSION['dog_name'] ?? 'Driver') ?></p>
    </div>

    <div class="container">
        <form action="log_entry.php" method="POST" enctype="multipart/form-data" class="card p-4">
            
            <div class="mb-4">
                <label class="form-label fw-bold">Current Location</label>
                <div class="input-group mb-2">
                    <span class="input-group-text">@</span>
                    <input type="text" name="location_name" class="form-control" placeholder="e.g. Love's, Receiver, Rest Area" required>
                </div>
                
                <div class="input-group">
                    <input type="text" id="city_state" name="location_city_state" class="form-control" placeholder="City, State">
                    <button type="button" class="btn btn-secondary" onclick="getLocation()">📍 GPS</button>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Environment</label>
                <select name="location_type" class="form-select">
                    <option value="In-Cab">In-Cab</option>
                    <option value="Truck Stop">Truck Stop</option>
                    <option value="Shipper/Receiver">Shipper/Receiver</option>
                    <option value="Public Store">Public Store</option>
                    <option value="Rest Area">Rest Area</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <hr>

            <div class="mb-4">
                <label class="form-label fw-bold d-block mb-3">Skills Practiced</label>
                <div class="row g-2">
                    <?php 
                    $skills = ['Sit/Stay', 'Heel', 'Leave It', 'Under Tuck', 'DPT Task', 'PA Focus'];
                    foreach($skills as $skill): ?>
                        <div class="col-6">
                            <input type="checkbox" name="skills[]" value="<?= $skill ?>" class="btn-check" id="btn_<?= $skill ?>">
                            <label class="btn btn-outline-primary w-100 py-2" for="btn_<?= $skill ?>"><?= $skill ?></label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr>

            <div class="mb-4">
                <label class="form-label fw-bold">Focus Level (1-5)</label>
                <input type="range" name="focus_level" class="form-range" min="1" max="5" step="1" id="focusRange">
                <div class="d-flex justify-content-between px-2">
                    <span>Distracted</span>
                    <span>Locked In</span>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Handler Notes</label>
                <textarea name="handler_notes" class="form-control" rows="3" placeholder="Notes on distractions, corrections, or wins..."></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Photo/Video Proof</label>
                <input type="file" name="training_media" class="form-control" accept="image/*,video/*">
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg fw-bold">SAVE SESSION</button>
                <a href="view_logs.php" class="btn btn-outline-secondary">View History</a>
            </div>
        </form>
    </div>

    <script>
    function getLocation() {
        const cityInput = document.getElementById('city_state');
        
        if (navigator.geolocation) {
            cityInput.value = "Locating...";
            
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                // Use free reverse geocoding API
                fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lng}&localityLanguage=en`)
                .then(response => response.json())
                .then(data => {
                    const city = data.city || data.locality || "Unknown City";
                    const state = data.principalSubdivision || "";
                    cityInput.value = city + (state ? ", " + state : "");
                })
                .catch(error => {
                    cityInput.value = "Error fetching city";
                    console.error(error);
                });
            }, function(error) {
                cityInput.value = "GPS Denied";
                alert("Please enable location permissions in your browser.");
            }, {
                enableHighAccuracy: true,
                timeout: 5000,
                maximumAge: 0
            });
        } else {
            cityInput.value = "Not supported";
        }
    }
    </script>

</body>
</html>
