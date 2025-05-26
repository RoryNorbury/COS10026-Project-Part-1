<?php
session_start();

// check if user is logged in
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    header('Location: user_login.php');
    exit;
}

require_once("settings.php");
require_once("update_user_progress.php");

// get user data from database
$conn = mysqli_connect($host, $user, $pswd, $dbnm);
if (!$conn) {
    die("Database connection failed");
}

$user_id = $_SESSION['user_id'];

// update user progress first
updateUserProgress($user_id, $conn);

// get updated user data
$stmt = mysqli_prepare($conn, "SELECT * FROM consciousness_uploads WHERE UploadID = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user_data = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user_data) {
    session_destroy();
    header('Location: user_login.php');
    exit;
}

// get user activities
$activity_stmt = mysqli_prepare($conn, "SELECT ActivityType, ActivityDescription, ActivityTimestamp, ImportanceLevel FROM user_activity_log WHERE UserID = ? ORDER BY ActivityTimestamp DESC LIMIT 10");
mysqli_stmt_bind_param($activity_stmt, 'i', $user_id);
mysqli_stmt_execute($activity_stmt);
$activities_result = mysqli_stmt_get_result($activity_stmt);
$activities = mysqli_fetch_all($activities_result, MYSQLI_ASSOC);
mysqli_stmt_close($activity_stmt);

// get user achievements
$achievement_stmt = mysqli_prepare($conn, "SELECT AchievementName, AchievementDescription, AchievementIcon, UnlockedTimestamp, PointsAwarded FROM user_achievements WHERE UserID = ? ORDER BY UnlockedTimestamp DESC");
mysqli_stmt_bind_param($achievement_stmt, 'i', $user_id);
mysqli_stmt_execute($achievement_stmt);
$achievements_result = mysqli_stmt_get_result($achievement_stmt);
$achievements = mysqli_fetch_all($achievements_result, MYSQLI_ASSOC);
mysqli_stmt_close($achievement_stmt);

// get digital assets
$assets_stmt = mysqli_prepare($conn, "SELECT AssetType, AssetName, AssetDescription, AssetIcon, AcquiredTimestamp FROM user_digital_assets WHERE UserID = ? AND IsActive = 1 ORDER BY AcquiredTimestamp DESC");
mysqli_stmt_bind_param($assets_stmt, 'i', $user_id);
mysqli_stmt_execute($assets_stmt);
$assets_result = mysqli_stmt_get_result($assets_stmt);
$digital_assets = mysqli_fetch_all($assets_result, MYSQLI_ASSOC);
mysqli_stmt_close($assets_stmt);

mysqli_close($conn);

// calculate user's age and digital age
$birth_date = new DateTime($user_data['DateOfBirth']);
$today = new DateTime();
$age = $birth_date->diff($today)->y;

$upload_date = new DateTime($user_data['UploadTimestamp']);
$digital_age = $today->diff($upload_date)->days;

// parse digital personality
$personality = json_decode($user_data['DigitalPersonality'], true);

// determine status
$status_message = "Upload Complete!";
$status_class = "complete";

switch ($user_data['Status']) {
    case 'Pending':
        $status_message = "Upload Queued";
        $status_class = "pending";
        break;
    case 'Processing':
        $status_message = "Processing Your Soul...";
        $status_class = "processing";
        break;
    case 'Failed':
        $status_message = "Upload Failed";
        $status_class = "failed";
        break;
}

$pageTitle = "Consciousness Dashboard - " . $user_data['FirstName'];
include 'header.inc';
include 'nav.inc';
?>

<body class="global_style upload_style manage_style">
    <div id="main-container" class="account-dashboard">
        <?php if (isset($_GET['welcome'])): ?>
            <div class="welcome-message">
                <h2>🎉 Welcome to Digital Immortality, <?= htmlspecialchars($user_data['FirstName']) ?>!</h2>
                <p>Your consciousness upload has been initiated. Watch your progress below!</p>
            </div>
        <?php endif; ?>

        <!-- header section -->
        <div class="dashboard-header">
            <h1>🧠 CONSCIOUSNESS DASHBOARD 🧠</h1>
            <div class="user-welcome">
                <h2>Welcome back, <?= htmlspecialchars($user_data['FirstName']) ?>!</h2>
                <p class="upload-status <?= $status_class ?>">Status: <?= $status_message ?></p>
                <div class="user-stats-quick">
                    <span class="stat">💎 <?= $user_data['VirtualCredits'] ?> Credits</span>
                    <span class="stat">⚡ <?= $user_data['DigitalEnergy'] ?>% Energy</span>
                    <span class="stat">🏆 <?= $user_data['AchievementPoints'] ?> Points</span>
                </div>
                <div class="user-controls">
                    <a href="user_login.php?logout=1" class="logout-btn">🚪 Disconnect</a>
                </div>
            </div>
        </div>

        <!-- main dashboard grid -->
        <div class="dashboard-grid">
            <!-- account info card -->
            <div class="dashboard-card account-info">
                <h3>👤 Account Information</h3>
                <div class="info-grid">
                    <div class="info-item"><label>Consciousness ID:</label><span class="consciousness-id">MM-<?= sprintf("%06d", $user_data['UploadID']) ?></span></div>
                    <div class="info-item"><label>Full Name:</label><span><?= htmlspecialchars($user_data['FirstName'] . " " . $user_data['LastName']) ?></span></div>
                    <div class="info-item"><label>Physical Age:</label><span><?= $age ?> years</span></div>
                    <div class="info-item"><label>Digital Age:</label><span class="digital-age"><?= $digital_age ?> days</span></div>
                    <div class="info-item"><label>Gender:</label><span><?= htmlspecialchars($user_data['Gender']) ?></span></div>
                    <div class="info-item"><label>Email:</label><span><?= htmlspecialchars($user_data['Email']) ?></span></div>
                    <div class="info-item"><label>Phone:</label><span><?= htmlspecialchars($user_data['Phone']) ?></span></div>
                    <div class="info-item"><label>Location:</label><span><?= htmlspecialchars($user_data['City'] . ", " . $user_data['State'] . " " . $user_data['Postcode']) ?></span></div>
                    <div class="info-item"><label>Upload Date:</label><span><?= date('M d, Y H:i', strtotime($user_data['UploadTimestamp'])) ?></span></div>
                    <?php if ($user_data['LastLogin']): ?>
                        <div class="info-item"><label>Last Access:</label><span><?= date('M d, Y H:i', strtotime($user_data['LastLogin'])) ?></span></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- upload progress card -->
            <div class="dashboard-card upload-progress">
                <h3>⚡ Upload Progress</h3>
                <div class="progress-details">
                    <div class="progress-container">
                        <div class="progress-label"><span>Consciousness Transfer</span><span class="progress-percent"><?= $user_data['UploadProgress'] ?>%</span></div>
                        <div class="progress-bar"><div class="progress-value" style="width: <?= $user_data['UploadProgress'] ?>%"></div></div>
                    </div>
                    <div class="upload-stats">
                        <div class="stat-item"><label>Neural Pathways Mapped:</label><span class="neural-count"><?= number_format($user_data['NeuralPathwaysMapped']) ?></span> / <?= number_format($user_data['NeuralPathwaysTotal']) ?></div>
                        <div class="stat-item"><label>Memory Fragments:</label><span class="memory-count"><?= number_format($user_data['MemoryFragmentsMapped']) ?></span> / <?= number_format($user_data['MemoryFragmentsTotal']) ?></div>
                        <div class="stat-item"><label>Server Location:</label><span><?= htmlspecialchars($user_data['ServerLocation']) ?></span></div>
                        <div class="stat-item"><label>Status:</label><span class="status-<?= $status_class ?>"><?= $user_data['Status'] ?></span></div>
                    </div>
                </div>
            </div>

            <!-- digital personality card -->
            <?php if ($personality): ?>
            <div class="dashboard-card personality-profile">
                <h3>🧬 Digital Personality Profile</h3>
                <div class="personality-stats">
                    <?php foreach ($personality as $trait => $value): ?>
                        <div class="personality-item">
                            <label><?= ucfirst($trait) ?>:</label>
                            <div class="personality-bar">
                                <div class="personality-fill" style="width: <?= $value ?>%"></div>
                            </div>
                            <span><?= $value ?>%</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- subscription details card -->
            <div class="dashboard-card subscription-info">
                <h3>💳 Subscription Details</h3>
                <div class="subscription-details">
                    <div class="plan-badge plan-<?= strtolower($user_data['SubscriptionPlan']) ?>"><?= strtoupper($user_data['SubscriptionPlan']) ?> PLAN</div>
                    
                    <?php
                    $plan_prices = ['Basic' => 49.99, 'Premium' => 199.99, 'Executive' => 999.99];
                    $plan_features = [
                        'Basic' => ['500MB thought storage', '2 hours active consciousness/day', 'Basic digital environment'],
                        'Premium' => ['Unlimited thought storage', '16 hours active consciousness/day', 'Premium virtual environments', 'Memory backup'],
                        'Executive' => ['Unlimited everything', '24/7 consciousness', 'IoT device possession', 'Reality manipulation beta access']
                    ];
                    ?>
                    
                    <div class="plan-price">$<?= $plan_prices[$user_data['SubscriptionPlan']] ?>/month</div>
                    <div class="plan-features">
                        <?php foreach ($plan_features[$user_data['SubscriptionPlan']] as $feature): ?>
                            <div class="feature">✓ <?= $feature ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="billing-info">
                        <p><strong>Next Billing:</strong> <?= date('M d, Y', strtotime('+1 month')) ?></p>
                        <p><strong>Payment Status:</strong> <span class="status-active">Active</span></p>
                        <p><strong>Virtual Credits:</strong> <span class="credits"><?= $user_data['VirtualCredits'] ?></span></p>
                    </div>
                </div>
            </div>

            <!-- system status card -->
            <div class="dashboard-card system-status">
                <h3>🖥️ System Status</h3>
                <div class="status-grid">
                    <div class="status-item">
                        <label>Consciousness Integrity:</label>
                        <div class="status-bar"><div class="status-fill" style="width: <?= $user_data['ConsciousnessIntegrity'] ?>%"></div></div>
                        <span><?= $user_data['ConsciousnessIntegrity'] ?>%</span>
                    </div>
                    <div class="status-item">
                        <label>Digital Stability:</label>
                        <div class="status-bar"><div class="status-fill" style="width: <?= $user_data['DigitalStability'] ?>%"></div></div>
                        <span><?= $user_data['DigitalStability'] ?>%</span>
                    </div>
                    <div class="status-item">
                        <label>Energy Level:</label>
                        <div class="status-bar"><div class="status-fill energy-bar" style="width: <?= $user_data['DigitalEnergy'] ?>%"></div></div>
                        <span><?= $user_data['DigitalEnergy'] ?>%</span>
                    </div>
                    <div class="status-item">
                        <label>Server Connection:</label>
                        <div class="connection-status online">🟢 ONLINE</div>
                    </div>
                </div>
            </div>

            <!-- achievements card -->
            <?php if (!empty($achievements)): ?>
            <div class="dashboard-card achievements">
                <h3>🏆 Achievements</h3>
                <div class="achievements-list">
                    <?php foreach ($achievements as $achievement): ?>
                        <div class="achievement-item">
                            <span class="achievement-icon"><?= $achievement['AchievementIcon'] ?></span>
                            <div class="achievement-details">
                                <strong><?= htmlspecialchars($achievement['AchievementName']) ?></strong>
                                <p><?= htmlspecialchars($achievement['AchievementDescription']) ?></p>
                                <small>+<?= $achievement['PointsAwarded'] ?> points • <?= date('M d', strtotime($achievement['UnlockedTimestamp'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- digital assets card -->
            <?php if (!empty($digital_assets)): ?>
            <div class="dashboard-card digital-assets">
                <h3>📦 Digital Assets</h3>
                <div class="assets-grid">
                    <?php foreach ($digital_assets as $asset): ?>
                        <div class="asset-item">
                            <span class="asset-icon"><?= $asset['AssetIcon'] ?></span>
                            <div class="asset-info">
                                <strong><?= htmlspecialchars($asset['AssetName']) ?></strong>
                                <p><?= htmlspecialchars($asset['AssetDescription']) ?></p>
                                <small><?= ucfirst($asset['AssetType']) ?> • <?= date('M d', strtotime($asset['AcquiredTimestamp'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- activity feed -->
            <div class="dashboard-card activity-feed">
                <h3>📡 Recent Activity</h3>
                <div class="activity-log">
                    <?php foreach ($activities as $activity): ?>
                        <div class="activity-item">
                            <span class="timestamp"><?= date('M d H:i', strtotime($activity['ActivityTimestamp'])) ?></span>
                            <span class="activity-type">[<?= $activity['ActivityType'] ?>]</span>
                            <?= htmlspecialchars($activity['ActivityDescription']) ?>
                            <?php if ($activity['ImportanceLevel'] == 'High' || $activity['ImportanceLevel'] == 'Critical'): ?>
                                <span class="importance-<?= strtolower($activity['ImportanceLevel']) ?>">●</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- emergency contacts card (if provided) -->
            <?php if (!empty($user_data['EmergencyContact'])): ?>
                <div class="dashboard-card emergency-contacts">
                    <h3>🚨 Emergency Contacts</h3>
                    <div class="contact-info">
                        <div class="contact-item">
                            <strong><?= htmlspecialchars($user_data['EmergencyContact']) ?></strong><br>
                            <?php if (!empty($user_data['EmergencyPhone'])): ?>
                                <span class="phone"><?= htmlspecialchars($user_data['EmergencyPhone']) ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="emergency-note">These contacts will be notified if your consciousness experiences critical errors or if your subscription lapses.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- action buttons -->
        <div class="dashboard-actions">
            <?php if ($user_data['Status'] != 'Uploaded'): ?>
                <button class="action-btn primary disabled" title="Available after upload completion">⚙️ Settings</button>
            <?php else: ?>
                <button class="action-btn primary disabled" title="Settings coming soon">⚙️ Settings</button>
            <?php endif; ?>
            <a href="terms.php" class="action-btn secondary" target="_blank">📜 View Terms</a>
            <a href="privacy.php" class="action-btn secondary" target="_blank">🔒 Privacy Policy</a>
            <a href="index.php" class="action-btn neutral">🏠 Home</a>
        </div>

        <!-- additional info -->
        <?php if (!empty($user_data['MedicalConditions']) || !empty($user_data['SpecialRequests'])): ?>
            <div class="additional-info">
                <h3>📋 Additional Information</h3>
                <?php if (!empty($user_data['MedicalConditions'])): ?>
                    <div class="info-section">
                        <h4>Medical Considerations:</h4>
                        <p><?= htmlspecialchars($user_data['MedicalConditions']) ?></p>
                    </div>
                <?php endif; ?>
                <?php if (!empty($user_data['SpecialRequests'])): ?>
                    <div class="info-section">
                        <h4>Special Requests:</h4>
                        <p><?= htmlspecialchars($user_data['SpecialRequests']) ?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>